<?php

namespace App\Filament\Teknisi\Pages;

use Filament\Pages\Dashboard;

class TeknisiDashboard extends Dashboard
{
    protected static ?string $title = 'Dasbor';
    protected static string $routePath = 'dashboard';

    public function getColumns(): int | array
    {
        return 1;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Teknisi\Widgets\TeknisiStatsWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            \App\Filament\Teknisi\Widgets\TeknisiReportChart::class,
        ];
    }
}