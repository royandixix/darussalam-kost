<?php

namespace App\Filament\Teknisi\Resources\MaintenanceUpdates;

use App\Filament\Teknisi\Resources\MaintenanceUpdates\Pages\CreateMaintenanceUpdate;
use App\Filament\Teknisi\Resources\MaintenanceUpdates\Pages\EditMaintenanceUpdate;
use App\Filament\Teknisi\Resources\MaintenanceUpdates\Pages\ListMaintenanceUpdates;
use App\Filament\Teknisi\Resources\MaintenanceUpdates\Schemas\MaintenanceUpdateForm;
use App\Filament\Teknisi\Resources\MaintenanceUpdates\Tables\MaintenanceUpdatesTable;
use App\Models\MaintenanceUpdate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MaintenanceUpdateResource extends Resource
{
    protected static ?string $model = MaintenanceUpdate::class;
    protected static ?string $navigationLabel = 'Catatan Perbaikan';
    protected static string|UnitEnum|null $navigationGroup = 'Layanan Perbaikan';
    protected static ?int $navigationSort = 2;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $recordTitleAttribute = 'note';

    public static function getModelLabel(): string
    {
        return 'Catatan Perbaikan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Catatan Perbaikan';
    }

    public static function form(Schema $schema): Schema
    {
        return MaintenanceUpdateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaintenanceUpdatesTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('technician_id', Auth::id());
    }

    public static function canEdit(Model $record): bool
    {
        return (int) $record->technician_id === (int) Auth::id();
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaintenanceUpdates::route('/'),
            'create' => CreateMaintenanceUpdate::route('/create'),
            'edit' => EditMaintenanceUpdate::route('/{record}/edit'),
        ];
    }
}
