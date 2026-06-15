<?php

namespace App\Filament\Teknisi\Widgets;

use App\Models\MaintenanceReport;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class TeknisiStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $counts = MaintenanceReport::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $pending = $counts['pending'] ?? 0;
        $inProgress = $counts['in_progress'] ?? 0;
        $completed = $counts['completed'] ?? 0;
        $total = $pending + $inProgress + $completed;

        return [
            Stat::make('Total Laporan', $total)
                ->description('Semua laporan masuk')
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->color('primary'),

            Stat::make('Menunggu', $pending)
                ->description('Belum dikerjakan')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Proses', $inProgress)
                ->description('Sedang diperbaiki')
                ->descriptionIcon('heroicon-o-wrench-screwdriver')
                ->color('info'),

            Stat::make('Selesai', $completed)
                ->description('Sudah selesai')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success'),
        ];
    }
}