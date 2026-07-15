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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MaintenanceReportResource extends Resource
{
    protected static ?string $model = MaintenanceReport::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Tugas Perbaikan';

    protected static string|UnitEnum|null $navigationGroup = 'Layanan Perbaikan';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getModelLabel(): string
    {
        return 'Tugas Perbaikan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Tugas Perbaikan';
    }

    public static function form(Schema $schema): Schema
    {
        return MaintenanceReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaintenanceReportsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(function (Builder $query): void {
                $query
                    ->where('assigned_technician_id', Auth::id())
                    ->orWhereNull('assigned_technician_id');
            });
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return $record->assigned_technician_id === null
            || (int) $record->assigned_technician_id === (int) Auth::id();
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaintenanceReports::route('/'),
            'edit' => EditMaintenanceReport::route('/{record}/edit'),
        ];
    }
}