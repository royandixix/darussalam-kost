<?php

namespace App\Filament\Resources\MaintenanceReports;

use App\Filament\Resources\MaintenanceReports\Pages\CreateMaintenanceReport;
use App\Filament\Resources\MaintenanceReports\Pages\EditMaintenanceReport;
use App\Filament\Resources\MaintenanceReports\Pages\ListMaintenanceReports;
use App\Filament\Resources\MaintenanceReports\Schemas\MaintenanceReportForm;
use App\Filament\Resources\MaintenanceReports\Tables\MaintenanceReportsTable;
use App\Models\MaintenanceReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MaintenanceReportResource extends Resource
{
    protected static ?string $model = MaintenanceReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

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
