<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;

    public function getTitle(): string
    {
        return 'Tambah Pemesanan Kamar';
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Pemesanan kamar berhasil ditambahkan';
    }
}