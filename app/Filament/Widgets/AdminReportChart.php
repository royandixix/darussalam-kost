<?php

namespace App\Filament\Widgets;

use App\Models\MaintenanceReport;
use Filament\Widgets\ChartWidget;

class AdminReportChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Laporan Maintenance';
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
        $pending = MaintenanceReport::where('status', 'pending')->count();
        $inProgress = MaintenanceReport::where('status', 'in_progress')->count();
        $completed = MaintenanceReport::where('status', 'completed')->count();

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
            $last7Days = collect(range(6, 0))->map(fn($day) =>
                now()->subDays($day)->format('d M')
            )->toArray();

            $pendingData = collect(range(6, 0))->map(fn($day) =>
                MaintenanceReport::where('status', 'pending')
                    ->whereDate('created_at', now()->subDays($day))->count()
            )->toArray();

            $completedData = collect(range(6, 0))->map(fn($day) =>
                MaintenanceReport::where('status', 'completed')
                    ->whereDate('updated_at', now()->subDays($day))->count()
            )->toArray();

            return [
                'datasets' => [
                    [
                        'label' => 'Menunggu',
                        'data' => $pendingData,
                        'borderColor' => '#f59e0b',
                        'backgroundColor' => '#fef3c7',
                        'fill' => true,
                        'tension' => 0.4,
                        'pointBackgroundColor' => '#f59e0b',
                        'pointRadius' => 4,
                    ],
                    [
                        'label' => 'Selesai',
                        'data' => $completedData,
                        'borderColor' => '#10b981',
                        'backgroundColor' => '#d1fae5',
                        'fill' => true,
                        'tension' => 0.4,
                        'pointBackgroundColor' => '#10b981',
                        'pointRadius' => 4,
                    ],
                ],
                'labels' => $last7Days,
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