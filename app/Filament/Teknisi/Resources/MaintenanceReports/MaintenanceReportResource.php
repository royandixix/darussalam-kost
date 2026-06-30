<?php

namespace App\Filament\Teknisi\Resources\MaintenanceReports;

use App\Filament\Teknisi\Resources\MaintenanceReports\Pages\EditMaintenanceReport;
use App\Filament\Teknisi\Resources\MaintenanceReports\Pages\ListMaintenanceReports;
use App\Filament\Teknisi\Resources\MaintenanceReports\Schemas\MaintenanceReportForm;
use App\Filament\Teknisi\Resources\MaintenanceReports\Tables\MaintenanceReportsTable;
use App\Models\MaintenanceReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class MaintenanceReportResource extends Resource
{
    protected static ?string $model = MaintenanceReport::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Laporan Kerusakan';

    protected static ?string $modelLabel = 'Laporan Kerusakan';

    protected static ?string $pluralModelLabel = 'Laporan Kerusakan';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 1;

    protected static string|UnitEnum|null $navigationGroup = 'Layanan Perbaikan';

    public static function form(Schema $schema): Schema
    {
        return MaintenanceReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaintenanceReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaintenanceReports::route('/'),
            'edit' => EditMaintenanceReport::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}