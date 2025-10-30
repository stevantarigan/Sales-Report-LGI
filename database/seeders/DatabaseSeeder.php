<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
            SalesTransactionSeeder::class,
            LocationSeeder::class,
            ActivityLogSeeder::class,
            SalesTargetSeeder::class,
        ]);
    }

}
