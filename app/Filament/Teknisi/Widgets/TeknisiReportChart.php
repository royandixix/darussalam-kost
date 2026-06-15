<?php

namespace App\Filament\Teknisi\Widgets;

use App\Models\MaintenanceReport;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TeknisiReportChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Laporan Teknisi';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;
    protected ?string $pollingInterval = '10s';
    protected ?string $maxHeight = '500px';

    public ?string $filter = 'bar';

    protected function getFilters(): ?array
    {
        return [
            'bar' => 'Bar Chart',
            'doughnut' => 'Donut Chart',
            'pie' => 'Pie Chart',
            'line' => 'Line Chart',
        ];
    }

    protected function getData(): array
    {
        $counts = MaintenanceReport::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $pending = $counts['pending'] ?? 0;
        $inProgress = $counts['in_progress'] ?? 0;
        $completed = $counts['completed'] ?? 0;

        if (in_array($this->filter, ['doughnut', 'pie'])) {
            return [
                'datasets' => [
                    [
                        'label' => 'Laporan',
                        'data' => [$pending, $inProgress, $completed],
                        'backgroundColor' => ['#f59e0b', '#3b82f6', '#10b981'],
                        'borderColor' => ['#d97706', '#2563eb', '#059669'],
                        'borderWidth' => 2,
                        'hoverOffset' => 8,
                    ],
                ],
                'labels' => ['Menunggu', 'Proses', 'Selesai'],
            ];
        }

        if ($this->filter === 'line') {
            $days = collect(range(6, 0))->map(fn($day) => now()->subDays($day)->format('Y-m-day'));
            $last7DaysLabels = collect(range(6, 0))->map(fn($day) => now()->subDays($day)->format('d M'))->toArray();

            $pendingDb = MaintenanceReport::where('status', 'pending')
                ->where('created_at', '>=', now()->subDays(6)->startOfDay())
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                ->groupBy('date')
                ->pluck('total', 'date')
                ->toArray();

            $completedDb = MaintenanceReport::where('status', 'completed')
                ->where('updated_at', '>=', now()->subDays(6)->startOfDay())
                ->select(DB::raw('DATE(updated_at) as date'), DB::raw('count(*) as total'))
                ->groupBy('date')
                ->pluck('total', 'date')
                ->toArray();

            $pendingData = [];
            $completedData = [];

            foreach (range(6, 0) as $day) {
                $dateKey = now()->subDays($day)->format('Y-m-d');
                $pendingData[] = $pendingDb[$dateKey] ?? 0;
                $completedData[] = $completedDb[$dateKey] ?? 0;
            }

            return [
                'datasets' => [
                    [
                        'label' => 'Menunggu',
                        'data' => $pendingData,
                        'borderColor' => '#f59e0b',
                        'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                        'fill' => true,
                        'tension' => 0.4,
                        'pointBackgroundColor' => '#f59e0b',
                        'pointRadius' => 4,
                    ],
                    [
                        'label' => 'Selesai',
                        'data' => $completedData,
                        'borderColor' => '#10b981',
                        'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                        'fill' => true,
                        'tension' => 0.4,
                        'pointBackgroundColor' => '#10b981',
                        'pointRadius' => 4,
                    ],
                ],
                'labels' => $last7DaysLabels,
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Laporan',
                    'data' => [$pending, $inProgress, $completed],
                    'backgroundColor' => ['#fbbf24', '#60a5fa', '#34d399'],
                    'borderColor' => ['#d97706', '#2563eb', '#059669'],
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => ['Menunggu', 'Proses', 'Selesai'],
        ];
    }

    protected function getType(): string
    {
        return $this->filter ?? 'bar';
    }
}