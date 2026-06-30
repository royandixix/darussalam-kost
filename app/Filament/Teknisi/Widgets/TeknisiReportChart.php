<?php

namespace App\Filament\Teknisi\Widgets;

use App\Models\MaintenanceReport;
use App\Models\MaintenanceUpdate;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class TeknisiReportChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Laporan Teknisi';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected ?string $pollingInterval = '5s';

    protected ?string $maxHeight = '500px';

    public ?string $filter = 'status';

    protected function getFilters(): ?array
    {
        return [
            'status' => 'Status Laporan',
            'priority' => 'Prioritas Laporan',
            'activity' => 'Aktivitas 7 Hari',
        ];
    }

    protected function getData(): array
    {
        return match ($this->filter) {
            'priority' => $this->priorityData(),
            'activity' => $this->activityData(),
            default => $this->statusData(),
        };
    }

    protected function getType(): string
    {
        return $this->filter === 'activity' ? 'line' : 'bar';
    }

    private function statusData(): array
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

    private function priorityData(): array
    {
        $low = MaintenanceReport::where('priority', 'low')->count();
        $medium = MaintenanceReport::where('priority', 'medium')->count();
        $high = MaintenanceReport::where('priority', 'high')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Laporan',
                    'data' => [$low, $medium, $high],
                    'backgroundColor' => ['#10b981', '#f59e0b', '#ef4444'],
                    'borderColor' => ['#059669', '#d97706', '#dc2626'],
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => ['Rendah', 'Sedang', 'Tinggi'],
        ];
    }

    private function activityData(): array
    {
        $labels = [];
        $reports = [];
        $updates = [];

        foreach (range(6, 0) as $day) {
            $date = now()->subDays($day);

            $labels[] = $date->format('d M');

            $reports[] = MaintenanceReport::whereDate('created_at', $date->toDateString())->count();

            $updates[] = MaintenanceUpdate::where('technician_id', Auth::id())
                ->whereDate('created_at', $date->toDateString())
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Laporan Masuk',
                    'data' => $reports,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#f59e0b',
                    'pointRadius' => 4,
                ],
                [
                    'label' => 'Catatan Saya',
                    'data' => $updates,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#10b981',
                    'pointRadius' => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }
}