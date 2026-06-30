<?php

namespace App\Filament\Teknisi\Pages;

use App\Filament\Teknisi\Widgets\TeknisiReportChart;
use App\Filament\Teknisi\Widgets\TeknisiStatsWidget;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;

class TeknisiDashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dasbor';

    protected static ?string $title = 'Dasbor';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = 0;

    public function getColumns(): int | array
    {
        return 3;
    }

    public function getWidgets(): array
    {
        return [
            TeknisiStatsWidget::class,
            TeknisiReportChart::class,
        ];
    }
}