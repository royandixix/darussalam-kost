<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    public function getTitle(): string
    {
        return 'Tambah Pembayaran';
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Pembayaran berhasil ditambahkan';
    }
}