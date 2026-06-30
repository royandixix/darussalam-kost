<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('room')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'available')
            ->latest()
            ->get();

        return view('user.bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'check_in_date' => ['required', 'date'],
            'duration_month' => ['required', 'integer', 'min:1'],
        ]);

        $room = Room::where('id', $request->room_id)
            ->where('status', 'available')
            ->firstOrFail();

        $totalPrice = $room->price * $request->duration_month;

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in_date' => $request->check_in_date,
            'duration_month' => $request->duration_month,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('user.bookings.index')
            ->with('success', 'Pemesanan kamar berhasil dikirim. Silakan tunggu konfirmasi admin.');
    }

    public function show(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        $booking->load(['room', 'payment', 'feedback']);

        return view('user.bookings.show', compact('booking'));
    }
}