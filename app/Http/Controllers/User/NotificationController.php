<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(15);

        return view('user.notifications.index', compact('notifications'));
    }

    public function read(DatabaseNotification $notification): RedirectResponse
    {
        abort_unless(
            $notification->notifiable_type === auth()->user()::class
            && (int) $notification->notifiable_id === (int) auth()->id(),
            403,
        );

        $notification->markAsRead();

        $url = data_get($notification->data, 'viewData.url');

        return $url ? redirect()->to($url) : back();
    }

    public function readAll(): RedirectResponse
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi sudah ditandai dibaca.');
    }
}
