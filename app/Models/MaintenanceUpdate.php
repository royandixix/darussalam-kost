<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceUpdate extends Model
{
    protected $fillable = [
        'maintenance_report_id',
        'technician_id',
        'note',
        'status',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(MaintenanceReport::class, 'maintenance_report_id');
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}