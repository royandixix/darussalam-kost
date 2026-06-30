<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Feedback;
use App\Models\MaintenanceReport;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $bookingIds = Booking::where('user_id', $user->id)->pluck('id');

        $totalBookings = Booking::where('user_id', $user->id)->count();

        $pendingBookings = Booking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $approvedBookings = Booking::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();

        $completedBookings = Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $totalPayments = Payment::whereIn('booking_id', $bookingIds)->count();

        $verifiedPayments = Payment::whereIn('booking_id', $bookingIds)
            ->where('status', 'verified')
            ->count();

        $pendingPayments = Payment::whereIn('booking_id', $bookingIds)
            ->where('status', 'pending')
            ->count();

        $totalMaintenance = MaintenanceReport::where('user_id', $user->id)->count();

        $pendingMaintenance = MaintenanceReport::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $completedMaintenance = MaintenanceReport::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $totalFeedback = Feedback::where('user_id', $user->id)->count();

        $latestBookings = Booking::with('room')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $latestMaintenance = MaintenanceReport::with('room')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $latestPayments = Payment::with('booking.room')
            ->whereIn('booking_id', $bookingIds)
            ->latest()
            ->take(5)
            ->get();

        $activities = collect();

        foreach ($latestBookings as $booking) {
            $activities->push([
                'type' => 'booking',
                'title' => 'Booking kamar ' . ($booking->room?->room_number ?? '-'),
                'description' => 'Status: ' . $this->bookingStatusLabel($booking->status),
                'date' => $booking->created_at,
                'icon' => 'bi-calendar-check',
                'color' => 'primary',
            ]);
        }

        foreach ($latestPayments as $payment) {
            $activities->push([
                'type' => 'payment',
                'title' => 'Pembayaran booking #' . $payment->booking_id,
                'description' => 'Status: ' . $this->paymentStatusLabel($payment->status),
                'date' => $payment->created_at,
                'icon' => 'bi-credit-card',
                'color' => 'success',
            ]);
        }

        foreach ($latestMaintenance as $report) {
            $activities->push([
                'type' => 'maintenance',
                'title' => $report->title,
                'description' => 'Kamar ' . ($report->room?->room_number ?? '-') . ' • ' . $this->maintenanceStatusLabel($report->status),
                'date' => $report->created_at,
                'icon' => 'bi-tools',
                'color' => 'danger',
            ]);
        }

        $activities = $activities
            ->sortByDesc('date')
            ->take(8)
            ->values();

        return view('user.dashboard.index', compact(
            'user',
            'totalBookings',
            'pendingBookings',
            'approvedBookings',
            'completedBookings',
            'totalPayments',
            'verifiedPayments',
            'pendingPayments',
            'totalMaintenance',
            'pendingMaintenance',
            'completedMaintenance',
            'totalFeedback',
            'latestBookings',
            'activities'
        ));
    }

    private function bookingStatusLabel(?string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
            default => '-',
        };
    }

    private function paymentStatusLabel(?string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default => '-',
        };
    }

    private function maintenanceStatusLabel(?string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu',
            'assigned' => 'Ditugaskan',
            'in_progress' => 'Sedang Dikerjakan',
            'completed' => 'Selesai',
            default => '-',
        };
    }
}