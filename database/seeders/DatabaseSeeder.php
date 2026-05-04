<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Super Admin
        User::create([
            'name' => 'Owner Apparel',
            'email' => 'admin@apparel.com',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
        ]);
    }
}