<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@toko.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'address' => 'Jl. Kesehatan No. 10, Jakarta',
            'phone' => '081234567890',
        ]);

        // Customer
        User::factory()->count(5)->create([
            'role' => 'customer'
        ]);
    }
}
