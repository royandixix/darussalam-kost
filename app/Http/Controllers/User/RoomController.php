<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::query()
            ->withExists('activeBookings')
            ->latest()
            ->get()
            ->each(function (Room $room): void {
                if ($room->status === 'available' && ! $room->isAvailableForBooking()) {
                    $room->setAttribute('status', 'sedang dipesan');
                }
            });

        return view('user.rooms.index', compact('rooms'));
    }

    public function show(Room $room)
    {
        $room->loadExists('activeBookings');

        if ($room->status === 'available' && ! $room->isAvailableForBooking()) {
            $room->setAttribute('status', 'sedang dipesan');
        }

        return view('user.rooms.show', compact('room'));
    }
}
