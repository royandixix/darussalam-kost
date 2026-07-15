<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingLifecycleService
{
    public function __construct(
        private readonly SystemNotificationService $notifications,
    ) {}

    public function assertRoomCanBeBooked(Room $room, ?int $ignoreBookingId = null): void
    {
        if ($room->status !== 'available') {
            throw ValidationException::withMessages([
                'room_id' => 'Kamar ini sedang tidak tersedia.',
            ]);
        }

        $conflictExists = Booking::query()
            ->where('room_id', $room->id)
            ->whereIn('status', ['pending', 'approved'])
            ->when($ignoreBookingId, fn ($query) => $query->whereKeyNot($ignoreBookingId))
            ->exists();

        if ($conflictExists) {
            throw ValidationException::withMessages([
                'room_id' => 'Kamar ini sudah memiliki pemesanan aktif. Silakan pilih kamar lain.',
            ]);
        }
    }

    public function synchronizeBooking(Booking $booking, bool $notifyUser = true): void
    {
        DB::transaction(function () use ($booking, $notifyUser): void {
            $booking = Booking::query()
                ->with(['user', 'room'])
                ->lockForUpdate()
                ->findOrFail($booking->id);

            $room = Room::query()->lockForUpdate()->findOrFail($booking->room_id);

            if ($booking->status === 'approved') {
                $conflictExists = Booking::query()
                    ->where('room_id', $room->id)
                    ->whereIn('status', ['pending', 'approved'])
                    ->whereKeyNot($booking->id)
                    ->exists();

                if ($conflictExists) {
                    throw ValidationException::withMessages([
                        'status' => 'Kamar ini sudah ditempati oleh booking lain.',
                    ]);
                }

                $room->update(['status' => 'occupied']);
                $this->activateTenant($booking);
            } elseif (in_array($booking->status, ['rejected', 'completed', 'pending'], true)) {
                $hasOtherApprovedBooking = Booking::query()
                    ->where('room_id', $room->id)
                    ->where('status', 'approved')
                    ->whereKeyNot($booking->id)
                    ->exists();

                if (! $hasOtherApprovedBooking && $room->status === 'occupied') {
                    $room->update(['status' => 'available']);
                }

                $this->deactivateTenant($booking);
            }

            if ($notifyUser) {
                $this->notifyBookingStatus($booking);
            }
        });
    }

    public function synchronizePayment(Payment $payment, bool $notifyUser = true): void
    {
        DB::transaction(function () use ($payment, $notifyUser): void {
            $payment = Payment::query()
                ->with(['booking.user', 'booking.room'])
                ->lockForUpdate()
                ->findOrFail($payment->id);

            $booking = $payment->booking;

            if (! $booking) {
                return;
            }

            if ($payment->status === 'verified') {
                $room = Room::query()->lockForUpdate()->findOrFail($booking->room_id);

                $conflictExists = Booking::query()
                    ->where('room_id', $room->id)
                    ->whereIn('status', ['pending', 'approved'])
                    ->whereKeyNot($booking->id)
                    ->exists();

                if ($conflictExists) {
                    throw ValidationException::withMessages([
                        'status' => 'Pembayaran tidak dapat diverifikasi karena kamar sudah ditempati booking lain.',
                    ]);
                }

                $booking->update(['status' => 'approved']);
                $room->update(['status' => 'occupied']);
                $this->activateTenant($booking->fresh(['user', 'room']));
            } else {
                $booking->update(['status' => 'pending']);

                $room = Room::query()->lockForUpdate()->findOrFail($booking->room_id);
                $hasOtherApprovedBooking = Booking::query()
                    ->where('room_id', $room->id)
                    ->where('status', 'approved')
                    ->whereKeyNot($booking->id)
                    ->exists();

                if (! $hasOtherApprovedBooking && $room->status === 'occupied') {
                    $room->update(['status' => 'available']);
                }

                $this->deactivateTenant($booking);
            }

            if ($notifyUser) {
                $this->notifyPaymentStatus($payment);
            }
        });
    }

    private function activateTenant(Booking $booking): void
    {
        $booking->loadMissing(['user', 'room']);

        if (! $booking->user) {
            return;
        }

        Tenant::query()->updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'user_id' => $booking->user_id,
                'name' => $booking->user->name,
                'phone' => $booking->user->phone ?: '-',
                'email' => $booking->user->email,
                'room_id' => $booking->room_id,
                'check_in_date' => $booking->check_in_date,
                'status' => 'active',
            ],
        );
    }

    private function deactivateTenant(Booking $booking): void
    {
        Tenant::query()
            ->where('booking_id', $booking->id)
            ->update(['status' => 'inactive']);
    }

    private function notifyBookingStatus(Booking $booking): void
    {
        $booking->loadMissing(['user', 'room']);

        $label = match ($booking->status) {
            'pending' => 'menunggu persetujuan',
            'approved' => 'disetujui',
            'rejected' => 'ditolak',
            'completed' => 'selesai',
            default => $booking->status,
        };

        $status = match ($booking->status) {
            'approved', 'completed' => 'success',
            'rejected' => 'danger',
            default => 'warning',
        };

        $this->notifications->user(
            $booking->user,
            'Status pemesanan diperbarui',
            'Pemesanan kamar ' . ($booking->room?->room_number ?? '-') . ' sekarang ' . $label . '.',
            route('user.bookings.show', $booking),
            $status,
        );
    }

    private function notifyPaymentStatus(Payment $payment): void
    {
        $payment->loadMissing(['booking.user', 'booking.room']);

        $label = match ($payment->status) {
            'pending' => 'menunggu verifikasi',
            'verified' => 'terverifikasi',
            'rejected' => 'ditolak',
            default => $payment->status,
        };

        $status = match ($payment->status) {
            'verified' => 'success',
            'rejected' => 'danger',
            default => 'warning',
        };

        $this->notifications->user(
            $payment->booking?->user,
            'Status pembayaran diperbarui',
            'Pembayaran kamar ' . ($payment->booking?->room?->room_number ?? '-') . ' sekarang ' . $label . '.',
            route('user.payments.index'),
            $status,
        );
    }
}
