<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::create([
            'name' => 'PT Sinar Terang',
            'phone' => '08123456789',
            'email' => 'sinarterang@gmail.com',
            'address' => 'Jl. Merdeka No. 10, Jakarta',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta'
        ]);

        Customer::create([
            'name' => 'CV Berkat Jaya',
            'phone' => '08234567890',
            'email' => 'berkatjaya@gmail.com',
            'address' => 'Jl. Sudirman No. 25, Medan',
            'city' => 'Medan',
            'province' => 'Sumatera Utara'
        ]);
    }
}
