<?php

namespace App\Filament\Resources\Tenants\Pages;

use App\Filament\Resources\Tenants\TenantResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;

    public function getTitle(): string
    {
        return 'Edit Data Penghuni';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Data penghuni berhasil diperbarui';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->modalHeading('Hapus Data Penghuni')
                ->modalDescription('Apakah Anda yakin ingin menghapus data penghuni ini?')
                ->modalSubmitActionLabel('Ya, Hapus'),
        ];
    }
}