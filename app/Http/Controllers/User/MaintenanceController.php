<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\MaintenanceReport;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaintenanceController extends Controller
{
    public function index()
    {
        $reports = MaintenanceReport::with([
                'room',
                'user',
                'updates.technician',
                'latestUpdate.technician',
            ])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.maintenance.index', compact('reports'));
    }

    public function create()
    {
        $roomIds = Booking::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->pluck('room_id')
            ->unique();

        $rooms = Room::whereIn('id', $roomIds)
            ->orderBy('room_number')
            ->get();

        return view('user.maintenance.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $hasBooking = Booking::where('user_id', Auth::id())
            ->where('room_id', $request->room_id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if (! $hasBooking) {
            return back()
                ->withInput()
                ->withErrors([
                    'room_id' => 'Kamar ini bukan kamar yang kamu booking.',
                ]);
        }

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
            'priority' => 'medium',
            'status' => 'pending',
        ]);

        return redirect()
            ->route('user.maintenance.index')
            ->with('success', 'Laporan perbaikan berhasil dikirim.');
    }

    public function edit(MaintenanceReport $maintenanceReport)
    {
        abort_if($maintenanceReport->user_id !== Auth::id(), 403);

        if ($maintenanceReport->status !== 'pending') {
            return redirect()
                ->route('user.maintenance.index')
                ->withErrors([
                    'maintenance' => 'Laporan yang sudah diproses tidak dapat diedit.',
                ]);
        }

        $roomIds = Booking::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->pluck('room_id')
            ->unique();

        $rooms = Room::whereIn('id', $roomIds)
            ->orderBy('room_number')
            ->get();

        return view('user.maintenance.edit', compact('maintenanceReport', 'rooms'));
    }

    public function update(Request $request, MaintenanceReport $maintenanceReport)
    {
        abort_if($maintenanceReport->user_id !== Auth::id(), 403);

        if ($maintenanceReport->status !== 'pending') {
            return redirect()
                ->route('user.maintenance.index')
                ->withErrors([
                    'maintenance' => 'Laporan yang sudah diproses tidak dapat diedit.',
                ]);
        }

        $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $hasBooking = Booking::where('user_id', Auth::id())
            ->where('room_id', $request->room_id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if (! $hasBooking) {
            return back()
                ->withInput()
                ->withErrors([
                    'room_id' => 'Kamar ini bukan kamar yang kamu booking.',
                ]);
        }

        $photoPath = $maintenanceReport->photo;

        if ($request->hasFile('photo')) {
            if ($maintenanceReport->photo) {
                Storage::disk('public')->delete($maintenanceReport->photo);
            }

            $photoPath = $request->file('photo')->store('maintenance-reports', 'public');
        }

        $maintenanceReport->update([
            'room_id' => $request->room_id,
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $photoPath,
        ]);

        return redirect()
            ->route('user.maintenance.index')
            ->with('success', 'Laporan perbaikan berhasil diperbarui.');
    }
}