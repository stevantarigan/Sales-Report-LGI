<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // SuperAdmin
        User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@sales.com',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
            'phone' => '08110000001',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // AdminSales 1
        User::create([
            'name' => 'Admin Sales 1',
            'email' => 'adminsales1@sales.com',
            'password' => Hash::make('password123'),
            'role' => 'adminsales',
            'phone' => '08110000002',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // AdminSales 2
        User::create([
            'name' => 'Admin Sales 2',
            'email' => 'adminsales2@sales.com',
            'password' => Hash::make('password123'),
            'role' => 'adminsales',
            'phone' => '08110000003',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Sales 1
        User::create([
            'name' => 'Sales Person 1',
            'email' => 'sales1@sales.com',
            'password' => Hash::make('password123'),
            'role' => 'sales',
            'phone' => '08110000004',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Sales 2
        User::create([
            'name' => 'Sales Person 2',
            'email' => 'sales2@sales.com',
            'password' => Hash::make('password123'),
            'role' => 'sales',
            'phone' => '08110000005',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // User tidak aktif
        User::create([
            'name' => 'Inactive User',
            'email' => 'inactive@sales.com',
            'password' => Hash::make('password123'),
            'role' => 'sales',
            'phone' => '08110000006',
            'is_active' => false,
            'email_verified_at' => now(),
        ]);
    }
}