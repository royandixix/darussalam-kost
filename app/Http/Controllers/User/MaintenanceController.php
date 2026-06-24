<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceReport;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function index()
    {
        $reports = MaintenanceReport::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.maintenance.index', compact('reports'));
    }

    public function create()
    {
        $rooms = Room::all();

        return view('user.maintenance.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'title' => ['required', 'max:255'],
            'description' => ['required'],
        ]);

        MaintenanceReport::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => 'medium',
            'status' => 'pending',
        ]);

        return redirect()
            ->route('user.maintenance.index')
            ->with('success', 'Laporan perbaikan berhasil dikirim.');
    }
}