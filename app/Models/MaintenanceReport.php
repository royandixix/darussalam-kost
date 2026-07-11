<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MaintenanceReport extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'title',
        'description',
        'photo',
        'priority',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function updates(): HasMany
    {
        return $this->hasMany(MaintenanceUpdate::class, 'maintenance_report_id');
    }

    public function latestUpdate(): HasOne
    {
        return $this->hasOne(MaintenanceUpdate::class, 'maintenance_report_id')->latestOfMany();
    }
}