<?php

namespace App\Http\Controllers\User;

use App\Filament\Resources\Payments\PaymentResource;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\SystemNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('booking.room')
            ->whereHas('booking', fn ($query) => $query->where('user_id', Auth::id()))
            ->latest()
            ->get();

        return view('user.payments.index', compact('payments'));
    }

    public function create()
    {
        $bookings = Booking::with(['room', 'payment'])
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->whereHas('payment', fn ($query) => $query->where('status', 'rejected'))
            ->latest()
            ->get();

        return view('user.payments.create', compact('bookings'));
    }

    public function store(Request $request, SystemNotificationService $notifications)
    {
        $validated = $request->validate([
            'booking_id' => ['required', 'integer', 'exists:bookings,id'],
            'payment_method' => ['required', 'in:bank_transfer,qris,cod'],
            'sender_name' => ['nullable', 'string', 'max:255'],
            'sender_bank' => ['nullable', 'string', 'max:255'],
            'payment_proof' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($validated['payment_method'] === 'bank_transfer') {
            $request->validate([
                'sender_name' => ['required', 'string', 'max:255'],
                'sender_bank' => ['required', 'string', 'max:255'],
                'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ]);
        }

        if ($validated['payment_method'] === 'qris') {
            $request->validate([
                'sender_name' => ['required', 'string', 'max:255'],
                'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ]);
        }

        $newProofPath = $request->hasFile('payment_proof')
            ? $request->file('payment_proof')->store('payment-proofs', 'public')
            : null;

        $oldProofPath = null;

        try {
            $payment = DB::transaction(function () use ($validated, $newProofPath, &$oldProofPath): Payment {
                $booking = Booking::query()
                    ->with('room')
                    ->whereKey($validated['booking_id'])
                    ->where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->lockForUpdate()
                    ->firstOrFail();

                $payment = Payment::query()
                    ->where('booking_id', $booking->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($payment->status !== 'rejected') {
                    throw ValidationException::withMessages([
                        'booking_id' => 'Pembayaran ini tidak dapat dikirim ulang karena statusnya bukan ditolak.',
                    ]);
                }

                $oldProofPath = $payment->payment_proof;

                $payment->update([
                    'amount' => $booking->room->price,
                    'payment_method' => $validated['payment_method'],
                    'sender_name' => in_array($validated['payment_method'], ['bank_transfer', 'qris'], true)
                        ? ($validated['sender_name'] ?? null)
                        : null,
                    'sender_bank' => $validated['payment_method'] === 'bank_transfer'
                        ? ($validated['sender_bank'] ?? null)
                        : null,
                    'payment_proof' => $newProofPath,
                    'payment_date' => now(),
                    'status' => 'pending',
                    'note' => null,
                ]);

                return $payment->fresh(['booking.user', 'booking.room']);
            }, attempts: 3);
        } catch (Throwable $exception) {
            if ($newProofPath) {
                Storage::disk('public')->delete($newProofPath);
            }

            throw $exception;
        }

        if ($oldProofPath && $oldProofPath !== $newProofPath) {
            Storage::disk('public')->delete($oldProofPath);
        }

        $notifications->admins(
            'Pembayaran dikirim ulang',
            $payment->booking->user->name . ' mengirim ulang pembayaran kamar ' . $payment->booking->room->room_number . '.',
            PaymentResource::getUrl('edit', ['record' => $payment]),
            'warning',
        );

        return redirect()
            ->route('user.payments.index')
            ->with('success', 'Pembayaran berhasil dikirim ulang. Silakan tunggu verifikasi admin.');
    }
}
