<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@fleetmanagement.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Fleet Manager',
            'email' => 'manager@fleetmanagement.com',
            'password' => Hash::make('password123'),
            'role' => 'manager',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
