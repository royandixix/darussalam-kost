<?php

namespace App\Filament\Widgets;

use App\Models\MaintenanceReport;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        $total = MaintenanceReport::count();
        $pending = MaintenanceReport::where('status', 'pending')->count();
        $inProgress = MaintenanceReport::where('status', 'in_progress')->count();
        $completed = MaintenanceReport::where('status', 'completed')->count();

        $successRate = $total > 0 ? round(($completed / $total) * 100) : 0;

        $last7Days = collect(range(6, 0))->map(fn($day) =>
            MaintenanceReport::whereDate('created_at', now()->subDays($day))->count()
        )->toArray();

        $last7Pending = collect(range(6, 0))->map(fn($day) =>
            MaintenanceReport::where('status', 'pending')
                ->whereDate('created_at', now()->subDays($day))->count()
        )->toArray();

        $last7InProgress = collect(range(6, 0))->map(fn($day) =>
            MaintenanceReport::where('status', 'in_progress')
                ->whereDate('updated_at', now()->subDays($day))->count()
        )->toArray();

        $last7Completed = collect(range(6, 0))->map(fn($day) =>
            MaintenanceReport::where('status', 'completed')
                ->whereDate('updated_at', now()->subDays($day))->count()
        )->toArray();

        return [
            Stat::make('Total Laporan', $total)
                ->description('Semua laporan masuk')
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->chart($last7Days)
                ->color('primary'),

            Stat::make('Menunggu', $pending)
                ->description($pending > 0 ? "{$pending} laporan perlu ditangani" : 'Tidak ada antrian')
                ->descriptionIcon($pending > 0 ? 'heroicon-o-exclamation-circle' : 'heroicon-o-clock')
                ->chart($last7Pending)
                ->color($pending > 5 ? 'danger' : 'warning'),

            Stat::make('Sedang Proses', $inProgress)
                ->description('Sedang diperbaiki teknisi')
                ->descriptionIcon('heroicon-o-wrench-screwdriver')
                ->chart($last7InProgress)
                ->color('info'),

            Stat::make('Selesai', $completed)
                ->description("Tingkat selesai {$successRate}%")
                ->descriptionIcon($successRate >= 80 ? 'heroicon-o-trophy' : 'heroicon-o-check-badge')
                ->chart($last7Completed)
                ->color($successRate >= 80 ? 'success' : 'warning'),
        ];
    }
}