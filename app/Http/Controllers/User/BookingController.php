<?php

namespace App\Http\Controllers\User;

use App\Filament\Resources\Bookings\BookingResource;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Services\BookingLifecycleService;
use App\Services\SystemNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['room', 'payment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $rooms = Room::query()
            ->where('status', 'available')
            ->whereDoesntHave('activeBookings')
            ->latest()
            ->get();

        $selectedRoomId = $request->query('room_id');

        return view('user.bookings.create', compact('rooms', 'selectedRoomId'));
    }

    public function store(
        Request $request,
        BookingLifecycleService $bookingLifecycle,
        SystemNotificationService $notifications,
    ) {
        $validated = $request->validate([
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
            'check_in_date' => ['required', 'date', 'after_or_equal:today'],
            'duration_month' => ['required', 'integer', 'min:1', 'max:36'],
            'payment_method' => ['required', 'in:bank_transfer,qris,cod'],
            'sender_name' => ['nullable', 'string', 'max:255'],
            'sender_bank' => ['nullable', 'string', 'max:255'],
            'payment_proof' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'room_id.required' => 'Kamar wajib dipilih.',
            'room_id.exists' => 'Kamar tidak ditemukan.',
            'check_in_date.required' => 'Tanggal masuk wajib diisi.',
            'check_in_date.after_or_equal' => 'Tanggal masuk tidak boleh sebelum hari ini.',
            'duration_month.required' => 'Lama sewa wajib diisi.',
            'duration_month.min' => 'Lama sewa minimal 1 bulan.',
            'duration_month.max' => 'Lama sewa maksimal 36 bulan.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_proof.image' => 'Bukti pembayaran harus berupa gambar.',
            'payment_proof.mimes' => 'Format bukti pembayaran harus JPG, JPEG, PNG, atau WEBP.',
            'payment_proof.max' => 'Ukuran bukti pembayaran maksimal 2 MB.',
        ]);

        if ($validated['payment_method'] === 'bank_transfer') {
            $request->validate([
                'sender_name' => ['required', 'string', 'max:255'],
                'sender_bank' => ['required', 'string', 'max:255'],
                'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ], [
                'sender_name.required' => 'Nama pengirim wajib diisi untuk transfer bank.',
                'sender_bank.required' => 'Bank pengirim wajib diisi untuk transfer bank.',
                'payment_proof.required' => 'Bukti transfer wajib diunggah.',
            ]);
        }

        if ($validated['payment_method'] === 'qris') {
            $request->validate([
                'sender_name' => ['required', 'string', 'max:255'],
                'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ], [
                'sender_name.required' => 'Nama pengirim wajib diisi untuk pembayaran QRIS.',
                'payment_proof.required' => 'Bukti pembayaran QRIS wajib diunggah.',
            ]);
        }

        $proofPath = $request->hasFile('payment_proof')
            ? $request->file('payment_proof')->store('payment-proofs', 'public')
            : null;

        try {
            $booking = DB::transaction(function () use ($validated, $proofPath, $bookingLifecycle): Booking {
                $room = Room::query()
                    ->lockForUpdate()
                    ->findOrFail($validated['room_id']);

                $bookingLifecycle->assertRoomCanBeBooked($room);

                $totalContractPrice = (float) $room->price * (int) $validated['duration_month'];
                $initialPayment = (float) $room->price;

                $booking = Booking::query()->create([
                    'user_id' => Auth::id(),
                    'room_id' => $room->id,
                    'check_in_date' => $validated['check_in_date'],
                    'duration_month' => $validated['duration_month'],
                    'total_price' => $totalContractPrice,
                    'status' => 'pending',
                ]);

                Payment::query()->create([
                    'booking_id' => $booking->id,
                    'amount' => $initialPayment,
                    'payment_method' => $validated['payment_method'],
                    'sender_name' => in_array($validated['payment_method'], ['bank_transfer', 'qris'], true)
                        ? ($validated['sender_name'] ?? null)
                        : null,
                    'sender_bank' => $validated['payment_method'] === 'bank_transfer'
                        ? ($validated['sender_bank'] ?? null)
                        : null,
                    'payment_proof' => $proofPath,
                    'payment_date' => now(),
                    'status' => 'pending',
                    'note' => null,
                ]);

                return $booking->load(['user', 'room', 'payment']);
            }, attempts: 3);
        } catch (Throwable $exception) {
            if ($proofPath) {
                Storage::disk('public')->delete($proofPath);
            }

            throw $exception;
        }

        $notifications->admins(
            'Pemesanan kamar baru',
            $booking->user->name . ' mengajukan pemesanan kamar ' . $booking->room->room_number . '.',
            BookingResource::getUrl('edit', ['record' => $booking]),
            'warning',
        );

        return redirect()
            ->route('user.bookings.show', $booking)
            ->with('success', 'Booking berhasil diajukan. Kamar otomatis dikunci dari pemesanan lain sampai admin memprosesnya.');
    }

    public function show(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        $booking->load(['room', 'payment', 'feedback']);

        return view('user.bookings.show', compact('booking'));
    }
}
