<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        Location::create([
            'user_id' => 1,
            'latitude' => '-6.200000',
            'longitude' => '106.816666',
            'address' => 'Jakarta Pusat',
            'note' => 'Lokasi transaksi pertama'
        ]);
    }
}
