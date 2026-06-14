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

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }
}
