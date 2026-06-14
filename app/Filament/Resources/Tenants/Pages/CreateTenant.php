<?php

namespace App\Filament\Resources\Tenants\Pages;

use App\Filament\Resources\Tenants\TenantResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;

    public function getTitle(): string
    {
        return 'Tambah Penghuni';
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data penghuni berhasil ditambahkan';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}