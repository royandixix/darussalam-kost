<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Feedback;
use App\Services\SystemNotificationService;
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
        $averageRating = $totalFeedback > 0 ? round((float) $feedbacks->avg('rating'), 1) : 0;
        $publishedFeedback = $feedbacks->where('is_published', true)->count();

        return view('user.feedback.index', compact(
            'feedbacks',
            'totalFeedback',
            'averageRating',
            'publishedFeedback',
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

    public function store(Request $request, SystemNotificationService $notifications)
    {
        $validated = $request->validate([
            'booking_id' => ['required', 'integer', 'exists:bookings,id'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $booking = Booking::with('room')
            ->whereKey($validated['booking_id'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['approved', 'completed'])
            ->whereDoesntHave('feedback')
            ->firstOrFail();

        $feedback = Feedback::query()->create([
            'user_id' => Auth::id(),
            'booking_id' => $booking->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_published' => false,
        ]);

        $notifications->admins(
            'Feedback penghuni baru',
            Auth::user()->name . ' memberi rating ' . $feedback->rating . '/5 untuk kamar ' . ($booking->room?->room_number ?? '-') . '.',
            url('/admin/feedback'),
            'info',
        );

        return redirect()
            ->route('user.feedback.index')
            ->with('success', 'Feedback berhasil dikirim dan menunggu publikasi admin.');
    }
}
