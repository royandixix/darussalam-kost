<?php

namespace App\Filament\Teknisi\Widgets;

use App\Models\MaintenanceReport;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TeknisiStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $total = MaintenanceReport::count();
        $pending = MaintenanceReport::where('status', 'pending')->count();
        $inProgress = MaintenanceReport::where('status', 'in_progress')->count();
        $completed = MaintenanceReport::where('status', 'completed')->count();

        return [
            Stat::make('Total Laporan', $total)
                ->description('Semua laporan masuk')
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->chart([7, 3, 4, 5, 6, $total])
                ->color('primary'),

            Stat::make('Menunggu', $pending)
                ->description('Belum dikerjakan')
                ->descriptionIcon('heroicon-o-clock')
                ->chart([2, 4, 3, 5, 4, $pending])
                ->color('warning'),

            Stat::make('Proses', $inProgress)
                ->description('Sedang diperbaiki')
                ->descriptionIcon('heroicon-o-wrench-screwdriver')
                ->chart([1, 2, 3, 2, 4, $inProgress])
                ->color('info'),

            Stat::make('Selesai', $completed)
                ->description('Sudah selesai')
                ->descriptionIcon('heroicon-o-check-badge')
                ->chart([3, 5, 4, 6, 5, $completed])
                ->color('success'),
        ];
    }
}