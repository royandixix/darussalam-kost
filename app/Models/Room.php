<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'price',
        'capacity',
        'size',
        'facilities',
        'photo',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'active_bookings_exists' => 'boolean',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function activeBookings(): HasMany
    {
        return $this->bookings()->whereIn('status', ['pending', 'approved']);
    }

    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }

    public function maintenanceReports(): HasMany
    {
        return $this->hasMany(MaintenanceReport::class);
    }

    public function isAvailableForBooking(): bool
    {
        if ($this->status !== 'available') {
            return false;
        }

        if (array_key_exists('active_bookings_exists', $this->getAttributes())) {
            return ! (bool) $this->getAttribute('active_bookings_exists');
        }

        return ! $this->activeBookings()->exists();
    }
}
