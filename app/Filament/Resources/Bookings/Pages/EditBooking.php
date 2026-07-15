<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Services\BookingLifecycleService;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    private ?string $oldStatus = null;

    public function getTitle(): string
    {
        return 'Kelola Pemesanan Kamar';
    }

    protected function beforeSave(): void
    {
        $this->oldStatus = $this->record->status;
    }

    protected function afterSave(): void
    {
        app(BookingLifecycleService::class)->synchronizeBooking(
            $this->record,
            notifyUser: $this->oldStatus !== $this->record->status,
        );
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Pemesanan kamar berhasil diperbarui';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
