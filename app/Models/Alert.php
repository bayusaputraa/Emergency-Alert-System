<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'triggered_at',
        'acknowledged_at',
        'acknowledged_by',
        'notes',
        'status'
    ];

    protected $dates = [
        'triggered_at',
        'acknowledged_at'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function acknowledgedBy()
    {
        return $this->belongsTo(User::class, 'acknowledged_by');
    }

    // Scope for pending alerts
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope for recent alerts
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('triggered_at', '>=', now()->subDays($days));
    }

    // Check if alert is acknowledged
    public function isAcknowledged()
    {
        return $this->status !== 'pending';
    }
}
