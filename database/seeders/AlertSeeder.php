<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alert;
use App\Models\Device;

class AlertSeeder extends Seeder
{
    public function run(): void
    {
        $device1 = Device::where('device_id', 'DEV-12345678')->first();
        $device2 = Device::where('device_id', 'DEV-87654321')->first();

        Alert::insert([
            [
                'device_id' => $device1->id ?? null,
                'triggered_at' => now()->subDays(2),
                'status' => 'resolved',
                'acknowledged_at' => now()->subDays(2)->addMinutes(5),
                'acknowledged_by' => 1,
                'notes' => 'False alarm, tested by security',
            ],
            [
                'device_id' => $device2->id ?? null,
                'triggered_at' => now()->subHours(5),
                'status' => 'pending',
                'acknowledged_at' => null,  // Menambahkan nilai default
                'acknowledged_by' => null,  // Menambahkan nilai default
                'notes' => null,  // Menambahkan nilai default
            ],
        ]);

    }
}
