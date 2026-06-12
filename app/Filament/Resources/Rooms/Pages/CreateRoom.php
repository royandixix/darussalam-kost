<?php

namespace App\Filament\Resources\Rooms\Pages;

use App\Filament\Resources\Rooms\RoomResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRoom extends CreateRecord
{
    protected static string $resource = RoomResource::class;

    public function getTitle(): string
    {
        return 'Tambah Kamar';
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data kamar berhasil ditambahkan';
    }
}