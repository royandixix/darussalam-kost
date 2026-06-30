<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\MaintenanceReport;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Tenant;
use Filament\Widgets\ChartWidget;

class AdminReportChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Monitoring Aplikasi';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected ?string $pollingInterval = '5s';

    protected ?string $maxHeight = '500px';

    public ?string $filter = 'maintenance_status';

    protected function getFilters(): ?array
    {
        return [
            'maintenance_status' => 'Status Maintenance',
            'booking_status' => 'Status Pemesanan',
            'payment_status' => 'Status Pembayaran',
            'room_status' => 'Status Kamar',
            'tenant_status' => 'Status Penghuni',
            'line_7days' => 'Aktivitas 7 Hari',
        ];
    }

    protected function getData(): array
    {
        return match ($this->filter) {
            'booking_status' => $this->bookingStatusData(),
            'payment_status' => $this->paymentStatusData(),
            'room_status' => $this->roomStatusData(),
            'tenant_status' => $this->tenantStatusData(),
            'line_7days' => $this->lineSevenDaysData(),
            default => $this->maintenanceStatusData(),
        };
    }

    protected function getType(): string
    {
        return $this->filter === 'line_7days' ? 'line' : 'bar';
    }

    private function maintenanceStatusData(): array
    {
        $pending = MaintenanceReport::where('status', 'pending')->count();
        $assigned = MaintenanceReport::where('status', 'assigned')->count();
        $inProgress = MaintenanceReport::where('status', 'in_progress')->count();
        $completed = MaintenanceReport::where('status', 'completed')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Laporan',
                    'data' => [$pending, $assigned, $inProgress, $completed],
                    'backgroundColor' => ['#f59e0b', '#8b5cf6', '#3b82f6', '#10b981'],
                    'borderColor' => ['#d97706', '#7c3aed', '#2563eb', '#059669'],
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => ['Menunggu', 'Ditugaskan', 'Proses', 'Selesai'],
        ];
    }

    private function bookingStatusData(): array
    {
        $pending = Booking::where('status', 'pending')->count();
        $approved = Booking::where('status', 'approved')->count();
        $rejected = Booking::where('status', 'rejected')->count();
        $completed = Booking::where('status', 'completed')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pemesanan',
                    'data' => [$pending, $approved, $rejected, $completed],
                    'backgroundColor' => ['#f59e0b', '#10b981', '#ef4444', '#3b82f6'],
                    'borderColor' => ['#d97706', '#059669', '#dc2626', '#2563eb'],
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => ['Menunggu', 'Disetujui', 'Ditolak', 'Selesai'],
        ];
    }

    private function paymentStatusData(): array
    {
        $pending = Payment::where('status', 'pending')->count();
        $verified = Payment::where('status', 'verified')->count();
        $rejected = Payment::where('status', 'rejected')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pembayaran',
                    'data' => [$pending, $verified, $rejected],
                    'backgroundColor' => ['#f59e0b', '#10b981', '#ef4444'],
                    'borderColor' => ['#d97706', '#059669', '#dc2626'],
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => ['Menunggu Verifikasi', 'Terverifikasi', 'Ditolak'],
        ];
    }

    private function roomStatusData(): array
    {
        $available = Room::where('status', 'available')->count();
        $occupied = Room::where('status', 'occupied')->count();
        $maintenance = Room::where('status', 'maintenance')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Kamar',
                    'data' => [$available, $occupied, $maintenance],
                    'backgroundColor' => ['#10b981', '#3b82f6', '#f59e0b'],
                    'borderColor' => ['#059669', '#2563eb', '#d97706'],
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => ['Tersedia', 'Terisi', 'Perbaikan'],
        ];
    }

    private function tenantStatusData(): array
    {
        $active = Tenant::where('status', 'active')->count();
        $inactive = Tenant::where('status', 'inactive')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Penghuni',
                    'data' => [$active, $inactive],
                    'backgroundColor' => ['#10b981', '#71717a'],
                    'borderColor' => ['#059669', '#52525b'],
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => ['Aktif', 'Tidak Aktif'],
        ];
    }

    private function lineSevenDaysData(): array
    {
        $labels = [];
        $bookings = [];
        $payments = [];
        $reports = [];
        $tenants = [];

        foreach (range(6, 0) as $day) {
            $date = now()->subDays($day);

            $labels[] = $date->format('d M');

            $bookings[] = Booking::whereDate('created_at', $date->toDateString())->count();

            $payments[] = Payment::whereDate('created_at', $date->toDateString())->count();

            $reports[] = MaintenanceReport::whereDate('created_at', $date->toDateString())->count();

            $tenants[] = Tenant::whereDate('created_at', $date->toDateString())->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pemesanan',
                    'data' => $bookings,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#3b82f6',
                    'pointRadius' => 4,
                ],
                [
                    'label' => 'Pembayaran',
                    'data' => $payments,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#10b981',
                    'pointRadius' => 4,
                ],
                [
                    'label' => 'Maintenance',
                    'data' => $reports,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#f59e0b',
                    'pointRadius' => 4,
                ],
                [
                    'label' => 'Penghuni',
                    'data' => $tenants,
                    'borderColor' => '#8b5cf6',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#8b5cf6',
                    'pointRadius' => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }
}