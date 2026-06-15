<?php

namespace App\Filament\Widgets;

use App\Models\MaintenanceReport;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class AdminStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected ?string $pollingInterval = '10s';

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

        $successRate = $total > 0 ? round(($completed / $total) * 100) : 0;

        $reportsDb = MaintenanceReport::where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->select(DB::raw('DATE(created_at) as date'), 'status', DB::raw('count(*) as total'))
            ->groupBy('date', 'status')
            ->get()
            ->groupBy('date');

        $updatedReportsDb = MaintenanceReport::whereIn('status', ['in_progress', 'completed'])
            ->where('updated_at', '>=', now()->subDays(6)->startOfDay())
            ->select(DB::raw('DATE(updated_at) as date'), 'status', DB::raw('count(*) as total'))
            ->groupBy('date', 'status')
            ->get()
            ->groupBy('date');

        $last7Days = [];
        $last7Pending = [];
        $last7InProgress = [];
        $last7Completed = [];

        foreach (range(6, 0) as $day) {
            $dateKey = now()->subDays($day)->format('Y-m-d');

            $dayCreatedReports = $reportsDb->get($dateKey, collect());
            $dayUpdatedReports = $updatedReportsDb->get($dateKey, collect());

            $last7Days[] = $dayCreatedReports->sum('total');
            
            $last7Pending[] = $dayCreatedReports->where('status', 'pending')->first()?->total ?? 0;
            
            $last7InProgress[] = $dayUpdatedReports->where('status', 'in_progress')->first()?->total ?? 0;
            
            $last7Completed[] = $dayUpdatedReports->where('status', 'completed')->first()?->total ?? 0;
        }

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