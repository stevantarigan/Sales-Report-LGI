<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesTarget;

class SalesTargetSeeder extends Seeder
{
    public function run(): void
    {
        SalesTarget::create([
            'user_id' => 1,
            'month' => 10,
            'year' => 2025,
            'target_amount' => 10000000,
            'achieved_amount' => 1500000
        ]);
    }
}
