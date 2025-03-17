<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Device;
use App\Models\Location;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        $location1 = Location::where('name', 'Main Office')->first();
        $location2 = Location::where('name', 'Warehouse')->first();

        Device::insert([
            [
                'device_id' => 'DEV-12345678',
                'name' => 'Emergency Button 1',
                'location_id' => $location1->id ?? null,
                'api_key' => bin2hex(random_bytes(16)),
                'is_active' => true,
                'description' => 'Tombol darurat di lobby utama',
            ],
            [
                'device_id' => 'DEV-87654321',
                'name' => 'Emergency Button 2',
                'location_id' => $location2->id ?? null,
                'api_key' => bin2hex(random_bytes(16)),
                'is_active' => true,
                'description' => 'Tombol darurat di pintu utama',
            ],
        ]);
    }
}
