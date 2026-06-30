<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\MaintenanceReport;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Tenant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected ?string $pollingInterval = '5s';

    protected function getStats(): array
    {
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();

        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('status', 'active')->count();

        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $approvedBookings = Booking::where('status', 'approved')->count();

        $totalPayments = Payment::count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $verifiedPayments = Payment::where('status', 'verified')->count();

        $totalReports = MaintenanceReport::count();
        $pendingReports = MaintenanceReport::where('status', 'pending')->count();
        $assignedReports = MaintenanceReport::where('status', 'assigned')->count();
        $inProgressReports = MaintenanceReport::where('status', 'in_progress')->count();
        $completedReports = MaintenanceReport::where('status', 'completed')->count();

        $roomChart = $this->dailyCounts(Room::class);
        $tenantChart = $this->dailyCounts(Tenant::class);
        $bookingChart = $this->dailyCounts(Booking::class);
        $paymentChart = $this->dailyCounts(Payment::class);
        $reportChart = $this->dailyCounts(MaintenanceReport::class);

        $completionRate = $totalReports > 0 ? round(($completedReports / $totalReports) * 100) : 0;

        return [
            Stat::make('Total Kamar', $totalRooms)
                ->description("Tersedia {$availableRooms}, Terisi {$occupiedRooms}, Perbaikan {$maintenanceRooms}")
                ->descriptionIcon('heroicon-o-home-modern')
                ->chart($roomChart)
                ->color('primary'),

            Stat::make('Penghuni Aktif', $activeTenants)
                ->description("Total data penghuni {$totalTenants}")
                ->descriptionIcon('heroicon-o-users')
                ->chart($tenantChart)
                ->color('success'),

            Stat::make('Pemesanan', $totalBookings)
                ->description("Menunggu {$pendingBookings}, Disetujui {$approvedBookings}")
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->chart($bookingChart)
                ->color($pendingBookings > 0 ? 'warning' : 'primary'),

            Stat::make('Pembayaran', $totalPayments)
                ->description("Menunggu {$pendingPayments}, Terverifikasi {$verifiedPayments}")
                ->descriptionIcon('heroicon-o-credit-card')
                ->chart($paymentChart)
                ->color($pendingPayments > 0 ? 'warning' : 'success'),

            Stat::make('Laporan Kerusakan', $totalReports)
                ->description("Menunggu {$pendingReports}, Ditugaskan {$assignedReports}, Proses {$inProgressReports}")
                ->descriptionIcon('heroicon-o-wrench-screwdriver')
                ->chart($reportChart)
                ->color($pendingReports > 0 ? 'danger' : 'info'),

            Stat::make('Maintenance Selesai', $completedReports)
                ->description("Tingkat selesai {$completionRate}%")
                ->descriptionIcon($completionRate >= 80 ? 'heroicon-o-trophy' : 'heroicon-o-check-badge')
                ->chart($reportChart)
                ->color($completionRate >= 80 ? 'success' : 'warning'),
        ];
    }

    private function dailyCounts(string $model): array
    {
        $data = [];

        foreach (range(6, 0) as $day) {
            $data[] = $model::query()
                ->whereDate('created_at', now()->subDays($day)->toDateString())
                ->count();
        }

        return $data;
    }
}