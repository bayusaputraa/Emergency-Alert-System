<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'name',
        'location_id',
        'api_key',
        'is_active',
        'description'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    // Generate a unique API key for this device
    public static function generateApiKey()
    {
        return bin2hex(random_bytes(16));
    }
}
