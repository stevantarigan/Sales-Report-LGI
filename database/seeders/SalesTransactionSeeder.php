<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesTransaction;

class SalesTransactionSeeder extends Seeder
{
    public function run(): void
    {
        SalesTransaction::create([
            'user_id' => 1,
            'customer_id' => 1,
            'product_id' => 1,
            'quantity' => 10,
            'price' => 15000,
            'total_price' => 150000,
            'payment_status' => 'paid',
            'status' => 'deal',
            'latitude' => '-6.200000',
            'longitude' => '106.816666',
            'map_link' => 'https://maps.google.com/?q=-6.200000,106.816666'
        ]);
    }
}
