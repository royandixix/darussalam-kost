<?php

namespace App\Filament\Resources\PaymentReports;

use App\Filament\Resources\PaymentReports\Pages\ListPaymentReports;
use App\Filament\Resources\PaymentReports\Tables\PaymentReportsTable;
use App\Models\Payment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use UnitEnum;

class PaymentReportResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Laporan Pembayaran';

    protected static string|UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'id';

    public static function getModelLabel(): string
    {
        return 'Laporan Pembayaran';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Laporan Pembayaran';
    }

    public static function table(Table $table): Table
    {
        return PaymentReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPaymentReports::route('/'),
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