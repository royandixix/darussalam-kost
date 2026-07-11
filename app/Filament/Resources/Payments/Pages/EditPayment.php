<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use App\Models\Payment;
use App\Models\Tenant;
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

    protected function afterSave(): void
    {
        $this->record->loadMissing('booking.user', 'booking.room');

        if ($this->record->status === 'verified') {
            $this->record->booking?->update([
                'status' => 'approved',
            ]);

            $this->record->booking?->room?->update([
                'status' => 'occupied',
            ]);

            $this->createOrUpdateTenant($this->record);
        }

        if ($this->record->status === 'rejected') {
            $this->record->booking?->update([
                'status' => 'pending',
            ]);

            $this->record->booking?->room?->update([
                'status' => 'available',
            ]);

            $this->deactivateTenantIfNeeded($this->record);
        }

        if ($this->record->status === 'pending') {
            $this->record->booking?->update([
                'status' => 'pending',
            ]);

            $this->record->booking?->room?->update([
                'status' => 'available',
            ]);

            $this->deactivateTenantIfNeeded($this->record);
        }
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

    private function deactivateTenantIfNeeded(Payment $payment): void
    {
        $payment->loadMissing('booking.user');

        $booking = $payment->booking;
        $user = $booking?->user;

        if (! $booking || ! $user) {
            return;
        }

        $hasOtherVerifiedPayment = Payment::query()
            ->where('id', '!=', $payment->id)
            ->where('status', 'verified')
            ->whereHas('booking', function ($query) use ($booking, $user) {
                $query->where('user_id', $user->id)
                    ->where('room_id', $booking->room_id);
            })
            ->exists();

        if ($hasOtherVerifiedPayment) {
            return;
        }

        Tenant::where('email', $user->email)
            ->where('room_id', $booking->room_id)
            ->update([
                'status' => 'inactive',
            ]);
    }
}