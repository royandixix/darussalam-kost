<?php

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use App\Services\BookingLifecycleService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function createUserWithRole(string $role, string $email): User
{
    return User::factory()->create([
        'role' => $role,
        'email' => $email,
        'phone' => '081234567890',
        'address' => 'Makassar',
    ]);
}

it('melindungi halaman penghuni berdasarkan role', function () {
    $admin = createUserWithRole('admin', 'admin-test@example.com');
    $penghuni = createUserWithRole('penghuni', 'penghuni-test@example.com');

    $this->actingAs($admin)
        ->get(route('user.dashboard'))
        ->assertForbidden();

    $this->actingAs($penghuni)
        ->get(route('user.dashboard'))
        ->assertOk();
});

it('mencegah kamar dipesan dua pengguna sekaligus', function () {
    Storage::fake('public');

    $room = Room::query()->create([
        'room_number' => 'A01',
        'price' => 850000,
        'capacity' => 1,
        'size' => 12,
        'facilities' => 'Wi-Fi',
        'status' => 'available',
    ]);

    $firstUser = createUserWithRole('penghuni', 'first@example.com');
    $secondUser = createUserWithRole('penghuni', 'second@example.com');

    $this->actingAs($firstUser)
        ->post(route('user.bookings.store'), [
            'room_id' => $room->id,
            'check_in_date' => now()->addDay()->toDateString(),
            'duration_month' => 6,
            'payment_method' => 'cod',
        ])
        ->assertRedirect();

    $this->actingAs($secondUser)
        ->from(route('user.rooms.index'))
        ->post(route('user.bookings.store'), [
            'room_id' => $room->id,
            'check_in_date' => now()->addDays(2)->toDateString(),
            'duration_month' => 3,
            'payment_method' => 'cod',
        ])
        ->assertSessionHasErrors('room_id');

    expect(Booking::query()->where('room_id', $room->id)->count())->toBe(1);
});

it('menghubungkan pembayaran booking kamar dan penghuni ketika diverifikasi', function () {
    $user = createUserWithRole('penghuni', 'tenant@example.com');

    $room = Room::query()->create([
        'room_number' => 'B01',
        'price' => 1000000,
        'capacity' => 1,
        'size' => 14,
        'facilities' => 'Wi-Fi',
        'status' => 'available',
    ]);

    $booking = Booking::query()->create([
        'user_id' => $user->id,
        'room_id' => $room->id,
        'check_in_date' => now()->addDay()->toDateString(),
        'duration_month' => 12,
        'total_price' => 12000000,
        'status' => 'pending',
    ]);

    $payment = Payment::query()->create([
        'booking_id' => $booking->id,
        'amount' => 1000000,
        'payment_method' => 'cod',
        'payment_date' => now(),
        'status' => 'verified',
    ]);

    app(BookingLifecycleService::class)->synchronizePayment($payment, notifyUser: false);

    expect($booking->fresh()->status)->toBe('approved')
        ->and($room->fresh()->status)->toBe('occupied');

    $tenant = Tenant::query()->where('booking_id', $booking->id)->first();

    expect($tenant)->not->toBeNull()
        ->and($tenant->user_id)->toBe($user->id)
        ->and($tenant->room_id)->toBe($room->id)
        ->and($tenant->status)->toBe('active');
});

it('hanya mengizinkan feedback satu kali untuk satu booking', function () {
    $user = createUserWithRole('penghuni', 'feedback@example.com');

    $room = Room::query()->create([
        'room_number' => 'C01',
        'price' => 750000,
        'capacity' => 1,
        'size' => 10,
        'facilities' => 'Wi-Fi',
        'status' => 'occupied',
    ]);

    $booking = Booking::query()->create([
        'user_id' => $user->id,
        'room_id' => $room->id,
        'check_in_date' => now()->toDateString(),
        'duration_month' => 1,
        'total_price' => 750000,
        'status' => 'approved',
    ]);

    $this->actingAs($user)
        ->post(route('user.feedback.store'), [
            'booking_id' => $booking->id,
            'rating' => 5,
            'comment' => 'Pelayanan sangat baik.',
        ])
        ->assertRedirect(route('user.feedback.index'));

    $this->actingAs($user)
        ->post(route('user.feedback.store'), [
            'booking_id' => $booking->id,
            'rating' => 4,
            'comment' => 'Feedback kedua.',
        ])
        ->assertNotFound();
});
