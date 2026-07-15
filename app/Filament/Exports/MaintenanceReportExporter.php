<?php

namespace App\Filament\Exports;

use App\Models\MaintenanceReport;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class MaintenanceReportExporter extends Exporter
{
    protected static ?string $model = MaintenanceReport::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('Kode Laporan'),
            ExportColumn::make('user.name')->label('Penghuni'),
            ExportColumn::make('room.room_number')->label('Nomor Kamar'),
            ExportColumn::make('assignedTechnician.name')->label('Teknisi'),
            ExportColumn::make('title')->label('Judul'),
            ExportColumn::make('description')
                ->label('Deskripsi')
                ->formatStateUsing(fn (?string $state): string => self::safeText($state)),
            ExportColumn::make('priority')
                ->label('Prioritas')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'low' => 'Rendah',
                    'medium' => 'Sedang',
                    'high' => 'Tinggi',
                    default => $state,
                }),
            ExportColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'pending' => 'Menunggu',
                    'assigned' => 'Ditugaskan',
                    'in_progress' => 'Sedang Dikerjakan',
                    'completed' => 'Selesai',
                    default => $state,
                }),
            ExportColumn::make('created_at')->label('Tanggal Laporan'),
            ExportColumn::make('updated_at')->label('Terakhir Diperbarui'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export maintenance selesai. ' . Number::format($export->successful_rows) . ' baris berhasil diekspor.';

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
