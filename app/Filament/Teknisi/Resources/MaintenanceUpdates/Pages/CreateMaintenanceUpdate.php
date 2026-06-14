<?php

namespace App\Filament\Teknisi\Resources\MaintenanceUpdates\Pages;

use App\Filament\Teknisi\Resources\MaintenanceUpdates\MaintenanceUpdateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMaintenanceUpdate extends CreateRecord
{
    protected static string $resource = MaintenanceUpdateResource::class;

    public function getTitle(): string
    {
        return 'Tambah Catatan Perbaikan';
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Catatan perbaikan berhasil ditambahkan';
    }
}