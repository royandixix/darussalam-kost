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
        $feedbacks = Feedback::with(['booking.room'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $totalFeedback = $feedbacks->count();

        $averageRating = $totalFeedback > 0
            ? round($feedbacks->avg('rating'), 1)
            : 0;

        $publishedFeedback = $feedbacks
            ->where('is_published', true)
            ->count();

        return view('user.feedback.index', compact(
            'feedbacks',
            'totalFeedback',
            'averageRating',
            'publishedFeedback'
        ));
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
        ], [
            'booking_id.required' => 'Booking wajib dipilih.',
            'booking_id.exists' => 'Booking yang dipilih tidak valid.',
            'rating.required' => 'Rating wajib dipilih.',
            'rating.integer' => 'Rating tidak valid.',
            'rating.min' => 'Rating minimal 1.',
            'rating.max' => 'Rating maksimal 5.',
            'comment.required' => 'Komentar wajib diisi.',
            'comment.max' => 'Komentar maksimal 1000 karakter.',
        ]);

        $booking = Booking::where('id', $request->booking_id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['approved', 'completed'])
            ->whereDoesntHave('feedback')
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