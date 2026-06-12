<?php

namespace App\Filament\Resources\Rooms\Pages;

use App\Filament\Resources\Rooms\RoomResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRoom extends EditRecord
{
    protected static string $resource = RoomResource::class;

    public function getTitle(): string
    {
        return 'Edit Kamar';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Data kamar berhasil diperbarui';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->modalHeading('Hapus Kamar')
                ->modalDescription('Apakah Anda yakin ingin menghapus data kamar ini?')
                ->modalSubmitActionLabel('Ya, Hapus'),
        ];
    }
}