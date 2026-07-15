<?php

namespace App\Http\Controllers\User;

use App\Filament\Resources\MaintenanceReports\MaintenanceReportResource;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\MaintenanceReport;
use App\Models\Room;
use App\Services\SystemNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaintenanceController extends Controller
{
    public function index()
    {
        $reports = MaintenanceReport::query()
            ->with([
                'room',
                'assignedTechnician',
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
        $rooms = Room::query()
            ->whereHas('bookings', function ($bookingQuery): void {
                $bookingQuery
                    ->where('user_id', Auth::id())
                    ->whereIn('status', ['approved', 'completed']);
            })
            ->orderBy('room_number')
            ->get();

        return view('user.maintenance.create', compact('rooms'));
    }

    public function store(
        Request $request,
        SystemNotificationService $notifications
    ) {
        $validated = $request->validate([
            'room_id' => [
                'required',
                'integer',
                'exists:rooms,id',
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
                'max:3000',
            ],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        if (! $this->userHasActiveRoom((int) $validated['room_id'])) {
            return back()
                ->withInput()
                ->withErrors([
                    'room_id' => 'Laporan hanya dapat dibuat untuk kamar yang sedang atau pernah disetujui untuk Anda tempati.',
                ]);
        }

        $photoPath = $request->hasFile('photo')
            ? $request->file('photo')->store(
                'maintenance-reports',
                'public'
            )
            : null;

        $report = MaintenanceReport::query()
            ->create([
                'user_id' => Auth::id(),
                'room_id' => $validated['room_id'],
                'assigned_technician_id' => null,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'photo' => $photoPath,
                'priority' => 'medium',
                'status' => 'pending',
            ])
            ->load([
                'user',
                'room',
            ]);

        $notifications->admins(
            'Laporan kerusakan baru',
            $report->user->name
                . ' melaporkan kerusakan di kamar '
                . $report->room->room_number
                . ': '
                . $report->title,
            MaintenanceReportResource::getUrl(
                'edit',
                ['record' => $report]
            ),
            'danger',
        );

        return redirect()
            ->route('user.maintenance.index')
            ->with(
                'success',
                'Laporan perbaikan berhasil dikirim kepada admin.'
            );
    }

    public function edit(
        MaintenanceReport $maintenanceReport
    ) {
        abort_if(
            (int) $maintenanceReport->user_id !== (int) Auth::id(),
            403
        );

        if ($maintenanceReport->status !== 'pending') {
            return redirect()
                ->route('user.maintenance.index')
                ->withErrors([
                    'maintenance' => 'Laporan yang sudah diproses tidak dapat diedit.',
                ]);
        }

        $rooms = Room::query()
            ->whereHas('bookings', function ($bookingQuery): void {
                $bookingQuery
                    ->where('user_id', Auth::id())
                    ->whereIn('status', ['approved', 'completed']);
            })
            ->orderBy('room_number')
            ->get();

        return view(
            'user.maintenance.edit',
            compact('maintenanceReport', 'rooms')
        );
    }

    public function update(
        Request $request,
        MaintenanceReport $maintenanceReport
    ) {
        abort_if(
            (int) $maintenanceReport->user_id !== (int) Auth::id(),
            403
        );

        abort_if(
            $maintenanceReport->status !== 'pending',
            422,
            'Laporan yang sudah diproses tidak dapat diedit.'
        );

        $validated = $request->validate([
            'room_id' => [
                'required',
                'integer',
                'exists:rooms,id',
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
                'max:3000',
            ],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        if (! $this->userHasActiveRoom((int) $validated['room_id'])) {
            return back()
                ->withInput()
                ->withErrors([
                    'room_id' => 'Kamar tersebut bukan kamar yang terhubung dengan akun Anda.',
                ]);
        }

        $photoPath = $maintenanceReport->photo;

        if ($request->hasFile('photo')) {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }

            $photoPath = $request
                ->file('photo')
                ->store('maintenance-reports', 'public');
        }

        $maintenanceReport->update([
            'room_id' => $validated['room_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'photo' => $photoPath,
        ]);

        return redirect()
            ->route('user.maintenance.index')
            ->with(
                'success',
                'Laporan perbaikan berhasil diperbarui.'
            );
    }

    private function userHasActiveRoom(int $roomId): bool
    {
        return Booking::query()
            ->where('user_id', Auth::id())
            ->where('room_id', $roomId)
            ->whereIn('status', ['approved', 'completed'])
            ->exists();
    }
}