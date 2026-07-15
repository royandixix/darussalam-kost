<?php

namespace App\Filament\Exports;

use App\Models\Tenant;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class TenantExporter extends Exporter
{
    protected static ?string $model = Tenant::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID Penghuni'),
            ExportColumn::make('booking_id')->label('Kode Booking'),
            ExportColumn::make('name')->label('Nama'),
            ExportColumn::make('phone')->label('Telepon'),
            ExportColumn::make('email')->label('Email'),
            ExportColumn::make('room.room_number')->label('Nomor Kamar'),
            ExportColumn::make('check_in_date')->label('Tanggal Masuk'),
            ExportColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn (string $state): string => $state === 'active' ? 'Aktif' : 'Tidak Aktif'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export penghuni selesai. ' . Number::format($export->successful_rows) . ' baris berhasil diekspor.';

        if ($failed = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failed) . ' baris gagal.';
        }

        return $body;
    }
}
