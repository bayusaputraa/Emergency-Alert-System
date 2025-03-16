<?php

namespace App\Models;

// namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'description',
        'contact_person',
        'contact_phone'
    ];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function activeDevices()
    {
        return $this->hasMany(Device::class)->where('is_active', true);
    }
}
