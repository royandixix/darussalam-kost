<?php

namespace App\Filament\Resources\TenantReports;

use App\Filament\Resources\TenantReports\Pages\ListTenantReports;
use App\Filament\Resources\TenantReports\Tables\TenantReportsTable;
use App\Models\Tenant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use UnitEnum;

class TenantReportResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationLabel = 'Laporan Penghuni';

    protected static string|UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'Laporan Penghuni';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Laporan Penghuni';
    }

    public static function table(Table $table): Table
    {
        return TenantReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTenantReports::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}