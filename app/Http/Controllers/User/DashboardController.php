<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $bookingIds = Booking::where('user_id', $user->id)->pluck('id');

        $totalBookings = Booking::where('user_id', $user->id)->count();

        $pendingBookings = Booking::where('user_id', $user->id)->where('status', 'pending')->count();

        $approvedBookings = Booking::where('user_id', $user->id)->where('status', 'approved')->count();

        $completedBookings = Booking::where('user_id', $user->id)->where('status', 'completed')->count();

        $totalPayments = Payment::whereIn('booking_id', $bookingIds)->count();

        $verifiedPayments = Payment::whereIn('booking_id', $bookingIds)->where('status', 'verified')->count();

        $pendingPayments = Payment::whereIn('booking_id', $bookingIds)->where('status', 'pending')->count();

        $latestBookings = Booking::where('user_id', $user->id)->latest()->take(5)->get();
        

        return view('user.dashboard.index', compact(
            'user',
            'totalBookings',
            'pendingBookings',
            'approvedBookings',
            'completedBookings',
            'totalPayments',
            'verifiedPayments',
            'pendingPayments',
            'latestBookings'
        ));
    }
}