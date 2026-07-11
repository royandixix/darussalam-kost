<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('booking.room')
            ->whereHas('booking', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('user.payments.index', compact('payments'));
    }

    public function create()
    {
        $bookings = Booking::with(['room', 'payment'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) {
                $query->whereDoesntHave('payment')
                    ->orWhereHas('payment', function ($paymentQuery) {
                        $paymentQuery->where('status', 'rejected');
                    });
            })
            ->latest()
            ->get();

        return view('user.payments.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
            'payment_method' => ['required', 'in:bank_transfer,qris,cod'],
            'sender_name' => ['nullable', 'string', 'max:255'],
            'sender_bank' => ['nullable', 'string', 'max:255'],
            'payment_proof' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->payment_method === 'bank_transfer') {
            $request->validate([
                'sender_name' => ['required', 'string', 'max:255'],
                'sender_bank' => ['required', 'string', 'max:255'],
                'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ]);
        }

        if ($request->payment_method === 'qris') {
            $request->validate([
                'sender_name' => ['required', 'string', 'max:255'],
                'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ]);
        }

        $booking = Booking::with('payment')
            ->where('id', $request->booking_id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->firstOrFail();

        if ($booking->payment && $booking->payment->status !== 'rejected') {
            return back()
                ->withInput()
                ->withErrors([
                    'booking_id' => 'Booking ini sudah memiliki pembayaran yang sedang diproses atau sudah terverifikasi.',
                ]);
        }

        $proofPath = null;

        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        if ($booking->payment && $booking->payment->status === 'rejected') {
            if ($booking->payment->payment_proof && $proofPath) {
                Storage::disk('public')->delete($booking->payment->payment_proof);
            }

            $booking->payment->update([
                'amount' => $booking->total_price,
                'payment_method' => $request->payment_method,
                'sender_name' => in_array($request->payment_method, ['bank_transfer', 'qris']) ? $request->sender_name : null,
                'sender_bank' => $request->payment_method === 'bank_transfer' ? $request->sender_bank : null,
                'payment_proof' => $proofPath,
                'payment_date' => now(),
                'status' => 'pending',
                'note' => null,
            ]);
        } else {
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $booking->total_price,
                'payment_method' => $request->payment_method,
                'sender_name' => in_array($request->payment_method, ['bank_transfer', 'qris']) ? $request->sender_name : null,
                'sender_bank' => $request->payment_method === 'bank_transfer' ? $request->sender_bank : null,
                'payment_proof' => $proofPath,
                'payment_date' => now(),
                'status' => 'pending',
                'note' => null,
            ]);
        }

        return redirect()
            ->route('user.payments.index')
            ->with('success', 'Data pembayaran berhasil dikirim. Silakan tunggu verifikasi admin.');
    }
}