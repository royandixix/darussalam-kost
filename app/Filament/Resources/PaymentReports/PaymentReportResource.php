<?php

namespace App\Filament\Resources\PaymentReports;

use App\Filament\Resources\PaymentReports\Pages\CreatePaymentReport;
use App\Filament\Resources\PaymentReports\Pages\EditPaymentReport;
use App\Filament\Resources\PaymentReports\Pages\ListPaymentReports;
use App\Filament\Resources\PaymentReports\Schemas\PaymentReportForm;
use App\Filament\Resources\PaymentReports\Tables\PaymentReportsTable;
use App\Models\Payment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
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

    public static function form(Schema $schema): Schema
    {
        return PaymentReportForm::configure($schema);
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
            'create' => CreatePaymentReport::route('/create'),
            'edit' => EditPaymentReport::route('/{record}/edit'),
        ];
    }
}