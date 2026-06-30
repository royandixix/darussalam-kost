<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with('booking.room')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        $bookings = Booking::with('room')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['approved', 'completed'])
            ->whereDoesntHave('feedback')
            ->latest()
            ->get();

        return view('user.feedback.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $booking = Booking::where('id', $request->booking_id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['approved', 'completed'])
            ->firstOrFail();

        Feedback::create([
            'user_id' => Auth::id(),
            'booking_id' => $booking->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_published' => false,
        ]);

        return redirect()
            ->route('user.feedback.index')
            ->with('success', 'Feedback berhasil dikirim.');
    }
}