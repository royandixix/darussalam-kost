<?php

namespace App\Filament\Exports;

use App\Models\Booking;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class BookingExporter extends Exporter
{
    protected static ?string $model = Booking::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('Kode Booking'),
            ExportColumn::make('user.name')->label('Nama Penghuni'),
            ExportColumn::make('user.email')->label('Email Penghuni'),
            ExportColumn::make('room.room_number')->label('Nomor Kamar'),
            ExportColumn::make('check_in_date')->label('Tanggal Masuk'),
            ExportColumn::make('duration_month')->label('Durasi Bulan'),
            ExportColumn::make('total_price')->label('Total Kontrak'),
            ExportColumn::make('status')
                ->label('Status Booking')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'pending' => 'Menunggu',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                    'completed' => 'Selesai',
                    default => $state,
                }),
            ExportColumn::make('created_at')->label('Tanggal Dibuat'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return self::message($export, 'booking');
    }

    private static function message(Export $export, string $label): string
    {
        $body = 'Export ' . $label . ' selesai. ' . Number::format($export->successful_rows) . ' baris berhasil diekspor.';

        if ($failed = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failed) . ' baris gagal.';
        }

        return $body;
    }
}
