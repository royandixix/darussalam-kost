<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['room', 'payment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $rooms = Room::where('status', 'available')
            ->latest()
            ->get();

        $selectedRoomId = $request->query('room_id');

        return view('user.bookings.create', compact('rooms', 'selectedRoomId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'check_in_date' => ['required', 'date'],
            'duration_month' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'in:bank_transfer,qris,cod'],
            'sender_name' => ['nullable', 'string', 'max:255'],
            'sender_bank' => ['nullable', 'string', 'max:255'],
            'payment_proof' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if (in_array($request->payment_method, ['bank_transfer', 'qris'])) {
            $request->validate([
                'sender_name' => ['required', 'string', 'max:255'],
                'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ]);
        }

        $room = Room::where('id', $request->room_id)
            ->where('status', 'available')
            ->firstOrFail();

        $totalPrice = $room->price * $request->duration_month;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in_date' => $request->check_in_date,
            'duration_month' => $request->duration_month,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        $proofPath = null;

        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $totalPrice,
            'payment_method' => $request->payment_method,
            'sender_name' => $request->payment_method === 'cod' ? null : $request->sender_name,
            'sender_bank' => $request->payment_method === 'cod' ? null : $request->sender_bank,
            'payment_proof' => $proofPath,
            'payment_date' => now(),
            'status' => 'pending',
            'note' => null,
        ]);

        return redirect()
            ->route('user.rooms.index')
            ->with('success', 'Booking berhasil diajukan. Silakan tunggu konfirmasi admin.');
    }

    public function show(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        $booking->load(['room', 'payment', 'feedback']);

        return view('user.bookings.show', compact('booking'));
    }
}