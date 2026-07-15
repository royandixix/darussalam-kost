<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use App\Services\BookingLifecycleService;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    private ?string $oldStatus = null;

    public function getTitle(): string
    {
        return 'Verifikasi Pembayaran';
    }

    protected function beforeSave(): void
    {
        $this->oldStatus = $this->record->status;
    }

    protected function afterSave(): void
    {
        app(BookingLifecycleService::class)->synchronizePayment(
            $this->record,
            notifyUser: $this->oldStatus !== $this->record->status,
        );
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Pembayaran berhasil diperbarui';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
