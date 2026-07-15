<?php

namespace App\Filament\Exports;

use App\Models\Feedback;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class FeedbackExporter extends Exporter
{
    protected static ?string $model = Feedback::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID Feedback'),
            ExportColumn::make('user.name')->label('Penghuni'),
            ExportColumn::make('booking.id')->label('Kode Booking'),
            ExportColumn::make('booking.room.room_number')->label('Nomor Kamar'),
            ExportColumn::make('rating')->label('Rating'),
            ExportColumn::make('comment')
                ->label('Komentar')
                ->formatStateUsing(fn (?string $state): string => self::safeText($state)),
            ExportColumn::make('is_published')
                ->label('Dipublikasikan')
                ->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak'),
            ExportColumn::make('created_at')->label('Tanggal Dibuat'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export feedback selesai. ' . Number::format($export->successful_rows) . ' baris berhasil diekspor.';

        if ($failed = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failed) . ' baris gagal.';
        }

        return $body;
    }

    private static function safeText(?string $value): string
    {
        $value = trim((string) $value);

        return preg_match('/^[=+\-@]/', $value) ? "'" . $value : $value;
    }
}
