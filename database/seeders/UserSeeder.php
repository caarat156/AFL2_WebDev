<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin HomeFragrance',
            'email' => 'adminlawasan@gmail.com',
            'password' => bcrypt ('admin123'),
            'role' => 'admin',
        ]);

        // User biasa
        User::create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt ('password123'),
            'role' => 'user',
        ]);

    }
}
