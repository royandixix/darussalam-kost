<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use App\Models\Payment;
use App\Models\Tenant;
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

    protected function afterCreate(): void
    {
        $this->record->loadMissing('booking.user', 'booking.room');

        if ($this->record->status !== 'verified') {
            return;
        }

        $this->record->booking?->update([
            'status' => 'approved',
        ]);

        $this->record->booking?->room?->update([
            'status' => 'occupied',
        ]);

        $this->createOrUpdateTenant($this->record);
    }

    private function createOrUpdateTenant(Payment $payment): void
    {
        $booking = $payment->booking;
        $user = $booking?->user;

        if (! $booking || ! $user) {
            return;
        }

        Tenant::updateOrCreate(
            [
                'email' => $user->email,
                'room_id' => $booking->room_id,
            ],
            [
                'name' => $user->name,
                'phone' => $user->phone ?? '-',
                'check_in_date' => $booking->check_in_date,
                'status' => 'active',
            ]
        );
    }
}