<?php

namespace App\Filament\Teknisi\Resources\MaintenanceUpdates\Pages;

use App\Filament\Teknisi\Resources\MaintenanceUpdates\MaintenanceUpdateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMaintenanceUpdate extends EditRecord
{
    protected static string $resource = MaintenanceUpdateResource::class;

    public function getTitle(): string
    {
        return 'Edit Catatan Perbaikan';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Catatan perbaikan berhasil diperbarui';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->modalHeading('Hapus Catatan Perbaikan')
                ->modalDescription('Apakah Anda yakin ingin menghapus data ini?')
                ->modalSubmitActionLabel('Ya, Hapus'),
        ];
    }
}