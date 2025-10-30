<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActivityLog;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        ActivityLog::create([
            'user_id' => 1,
            'action' => 'create',
            'model' => 'SalesTransaction',
            'description' => 'Sales Stevan menambahkan transaksi baru.'
        ]);
    }
}
