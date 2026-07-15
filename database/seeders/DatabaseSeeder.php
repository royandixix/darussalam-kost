<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@darussalam.test'],
            [
                'name' => 'Admin Darussalam',
                'phone' => '081234567890',
                'address' => 'Kosan Darussalam',
                'role' => 'admin',
                'password' => Hash::make('password123'),
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'teknisi@darussalam.test'],
            [
                'name' => 'Teknisi Darussalam',
                'phone' => '081234567891',
                'address' => 'Kosan Darussalam',
                'role' => 'teknisi',
                'password' => Hash::make('password123'),
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'penghuni@darussalam.test'],
            [
                'name' => 'Penghuni Demo',
                'phone' => '081234567892',
                'address' => 'Makassar',
                'role' => 'penghuni',
                'password' => Hash::make('password123'),
            ],
        );

        foreach ([
            ['room_number' => 'A01', 'price' => 850000, 'capacity' => 1, 'size' => 12],
            ['room_number' => 'A02', 'price' => 900000, 'capacity' => 1, 'size' => 14],
            ['room_number' => 'B01', 'price' => 1100000, 'capacity' => 2, 'size' => 18],
        ] as $room) {
            Room::query()->firstOrCreate(
                ['room_number' => $room['room_number']],
                [
                    ...$room,
                    'facilities' => 'Kasur, lemari, meja belajar, kamar mandi, Wi-Fi',
                    'status' => 'available',
                ],
            );
        }
    }
}
