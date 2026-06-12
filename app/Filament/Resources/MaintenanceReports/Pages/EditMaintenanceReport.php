<?php

namespace App\Filament\Resources\MaintenanceReports\Pages;

use App\Filament\Resources\MaintenanceReports\MaintenanceReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMaintenanceReport extends EditRecord
{
    protected static string $resource = MaintenanceReportResource::class;

    public function getTitle(): string
    {
        return 'Edit Laporan Perbaikan';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Laporan perbaikan berhasil diperbarui';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->modalHeading('Hapus Laporan Perbaikan')
                ->modalDescription('Apakah Anda yakin ingin menghapus laporan perbaikan ini?')
                ->modalSubmitActionLabel('Ya, Hapus'),
        ];
    }
}