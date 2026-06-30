<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\MaintenanceReport;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function index()
    {
        $reports = MaintenanceReport::with('room')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.maintenance.index', compact('reports'));
    }

    public function create()
    {
        $roomIds = Booking::where('user_id', Auth::id())
            ->whereIn('status', ['approved', 'completed'])
            ->pluck('room_id');

        $rooms = Room::whereIn('id', $roomIds)->get();

        return view('user.maintenance.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['nullable', 'in:low,medium,high'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $roomIds = Booking::where('user_id', Auth::id())
            ->whereIn('status', ['approved', 'completed'])
            ->pluck('room_id')
            ->toArray();

        abort_if(! in_array((int) $request->room_id, $roomIds), 403);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('maintenance-reports', 'public');
        }

        MaintenanceReport::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $photoPath,
            'priority' => $request->priority ?? 'medium',
            'status' => 'pending',
        ]);

        return redirect()
            ->route('user.maintenance.index')
            ->with('success', 'Laporan kerusakan berhasil dikirim.');
    }
}