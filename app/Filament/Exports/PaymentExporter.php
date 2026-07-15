<?php

namespace App\Filament\Exports;

use App\Models\Payment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PaymentExporter extends Exporter
{
    protected static ?string $model = Payment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('Kode Pembayaran'),
            ExportColumn::make('booking.id')->label('Kode Booking'),
            ExportColumn::make('booking.user.name')->label('Nama Penghuni'),
            ExportColumn::make('booking.room.room_number')->label('Nomor Kamar'),
            ExportColumn::make('amount')->label('Jumlah'),
            ExportColumn::make('payment_method')
                ->label('Metode')
                ->formatStateUsing(fn (?string $state): string => match ($state) {
                    'bank_transfer' => 'Transfer Bank',
                    'qris' => 'QRIS',
                    'cod' => 'COD',
                    default => '-',
                }),
            ExportColumn::make('sender_name')->label('Nama Pengirim'),
            ExportColumn::make('sender_bank')->label('Bank/Aplikasi'),
            ExportColumn::make('payment_date')->label('Tanggal Pembayaran'),
            ExportColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'pending' => 'Menunggu Verifikasi',
                    'verified' => 'Terverifikasi',
                    'rejected' => 'Ditolak',
                    default => $state,
                }),
            ExportColumn::make('note')->label('Catatan Admin'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export pembayaran selesai. ' . Number::format($export->successful_rows) . ' baris berhasil diekspor.';

        if ($failed = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failed) . ' baris gagal.';
        }

        return $body;
    }
}
