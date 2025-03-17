<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        Location::insert([
            [
                'name' => 'Main Office',
                'address' => 'Jl. Raya Bekasi No. 123',
                'description' => 'Kantor pusat perusahaan',
                'contact_person' => 'John Doe',
                'contact_phone' => '081234567890',
            ],
            [
                'name' => 'Warehouse',
                'address' => 'Jl. Industri No. 45',
                'description' => 'Gudang penyimpanan barang',
                'contact_person' => 'Jane Smith',
                'contact_phone' => '081234567891',
            ],
        ]);
    }
}
