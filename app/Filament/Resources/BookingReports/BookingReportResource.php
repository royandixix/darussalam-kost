<?php

namespace App\Filament\Resources\BookingReports;

use App\Filament\Resources\BookingReports\Pages\CreateBookingReport;
use App\Filament\Resources\BookingReports\Pages\EditBookingReport;
use App\Filament\Resources\BookingReports\Pages\ListBookingReports;
use App\Filament\Resources\BookingReports\Schemas\BookingReportForm;
use App\Filament\Resources\BookingReports\Tables\BookingReportsTable;
use App\Models\MaintenanceReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class BookingReportResource extends Resource
{
    protected static ?string $model = MaintenanceReport::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Laporan Maintenance';

    protected static string|UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getModelLabel(): string
    {
        return 'Laporan Maintenance';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Laporan Maintenance';
    }

    public static function form(Schema $schema): Schema
    {
        return BookingReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookingReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookingReports::route('/'),
            'create' => CreateBookingReport::route('/create'),
            'edit' => EditBookingReport::route('/{record}/edit'),
        ];
    }
}