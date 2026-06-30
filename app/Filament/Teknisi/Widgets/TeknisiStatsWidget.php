<?php

namespace App\Filament\Teknisi\Widgets;

use App\Models\MaintenanceReport;
use App\Models\MaintenanceUpdate;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class TeknisiStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $pollingInterval = '5s';

    protected function getStats(): array
    {
        $totalReports = MaintenanceReport::count();
        $pending = MaintenanceReport::where('status', 'pending')->count();
        $assigned = MaintenanceReport::where('status', 'assigned')->count();
        $inProgress = MaintenanceReport::where('status', 'in_progress')->count();
        $completed = MaintenanceReport::where('status', 'completed')->count();

        $myUpdates = MaintenanceUpdate::where('technician_id', Auth::id())->count();

        $completionRate = $totalReports > 0 ? round(($completed / $totalReports) * 100) : 0;

        return [
            Stat::make('Total Laporan', $totalReports)
                ->description('Semua laporan kerusakan')
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->chart($this->dailyReportCounts())
                ->color('primary'),

            Stat::make('Menunggu', $pending)
                ->description('Belum ditangani')
                ->descriptionIcon('heroicon-o-clock')
                ->chart($this->dailyReportCounts('pending'))
                ->color($pending > 0 ? 'warning' : 'success'),

            Stat::make('Ditugaskan', $assigned)
                ->description('Sudah masuk antrian teknisi')
                ->descriptionIcon('heroicon-o-user-circle')
                ->chart($this->dailyReportCounts('assigned'))
                ->color('info'),

            Stat::make('Sedang Proses', $inProgress)
                ->description('Sedang diperbaiki')
                ->descriptionIcon('heroicon-o-wrench-screwdriver')
                ->chart($this->dailyReportCounts('in_progress'))
                ->color('info'),

            Stat::make('Selesai', $completed)
                ->description("Tingkat selesai {$completionRate}%")
                ->descriptionIcon('heroicon-o-check-badge')
                ->chart($this->dailyReportCounts('completed'))
                ->color('success'),

            Stat::make('Catatan Saya', $myUpdates)
                ->description('Update yang dibuat teknisi ini')
                ->descriptionIcon('heroicon-o-pencil-square')
                ->chart($this->dailyUpdateCounts())
                ->color('primary'),
        ];
    }

    private function dailyReportCounts(?string $status = null): array
    {
        $data = [];

        foreach (range(6, 0) as $day) {
            $query = MaintenanceReport::query()
                ->whereDate('created_at', now()->subDays($day)->toDateString());

            if ($status) {
                $query->where('status', $status);
            }

            $data[] = $query->count();
        }

        return $data;
    }

    private function dailyUpdateCounts(): array
    {
        $data = [];

        foreach (range(6, 0) as $day) {
            $data[] = MaintenanceUpdate::query()
                ->where('technician_id', Auth::id())
                ->whereDate('created_at', now()->subDays($day)->toDateString())
                ->count();
        }

        return $data;
    }
}