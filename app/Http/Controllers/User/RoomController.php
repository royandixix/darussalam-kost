<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 'available')->get();
        return view('user.rooms.index', compact('rooms'));
    }

    public function show(Room $room)
    {
        return view('user.rooms.show', compact('room'));
    }
}