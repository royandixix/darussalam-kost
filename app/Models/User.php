<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->role === 'admin',
            'teknisi' => $this->role === 'teknisi',
            'penghuni' => $this->role === 'penghuni',
            default => false,
        };
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function maintenanceReports(): HasMany
    {
        return $this->hasMany(MaintenanceReport::class);
    }

    public function maintenanceUpdates(): HasMany
    {
        return $this->hasMany(MaintenanceUpdate::class, 'technician_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTeknisi(): bool
    {
        return $this->role === 'teknisi';
    }

    // public function isPenghuni(): bool
    // {
    //     return $this->role === 'penghuni';
    // }

    public function isPenghuni(): bool
    {
        return $this->role === 'penghuni';
    }


    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Administrator',
            'teknisi' => 'Teknisi',
            'penghuni' => 'Penghuni',
            default => 'Pengguna',
        };
    }
}