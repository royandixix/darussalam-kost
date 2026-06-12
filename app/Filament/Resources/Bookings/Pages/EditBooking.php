<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    public function getTitle(): string
    {
        return 'Edit Pemesanan Kamar';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Pemesanan kamar berhasil diperbarui';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->modalHeading('Hapus Pemesanan Kamar')
                ->modalDescription('Apakah Anda yakin ingin menghapus pemesanan kamar ini?')
                ->modalSubmitActionLabel('Ya, Hapus'),
        ];
    }
}