<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    public function getTitle(): string
    {
        return 'Edit Pembayaran';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Pembayaran berhasil diperbarui';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->modalHeading('Hapus Pembayaran')
                ->modalDescription('Apakah Anda yakin ingin menghapus pembayaran ini?')
                ->modalSubmitActionLabel('Ya, Hapus'),
        ];
    }
}