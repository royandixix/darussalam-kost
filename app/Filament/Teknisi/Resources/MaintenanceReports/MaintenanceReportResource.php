<?php

namespace App\Filament\Teknisi\Resources\MaintenanceReports;

use App\Filament\Teknisi\Resources\MaintenanceReports\Pages\CreateMaintenanceReport;
use App\Filament\Teknisi\Resources\MaintenanceReports\Pages\EditMaintenanceReport;
use App\Filament\Teknisi\Resources\MaintenanceReports\Pages\ListMaintenanceReports;
use App\Filament\Teknisi\Resources\MaintenanceReports\Schemas\MaintenanceReportForm;
use App\Filament\Teknisi\Resources\MaintenanceReports\Tables\MaintenanceReportsTable;
use App\Models\MaintenanceReport;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MaintenanceReportResource extends Resource
{
    protected static ?string $navigationLabel = 'Laporan Kerusakan';

    protected static ?string $modelLabel = 'Laporan Kerusakan';

    protected static ?string $pluralModelLabel = 'Laporan Kerusakan';

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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaintenanceReports::route('/'),
            'create' => CreateMaintenanceReport::route('/create'),
            'edit' => EditMaintenanceReport::route('/{record}/edit'),
        ];
    }
}
