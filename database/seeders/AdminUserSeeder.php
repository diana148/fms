<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // Don't forget to import Hash
use Carbon\Carbon; // For timestamps

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an Admin user
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com', // Use an email you'll remember
            'password' => Hash::make('password'), // Use a strong password in production!
            'role' => 'admin', // Set the role to 'admin'
            'email_verified_at' => Carbon::now(), // Optional: if you have email verification
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Create a Manager user
        DB::table('users')->insert([
            'name' => 'Manager User',
            'email' => 'manager@example.com', // Use an email you'll remember
            'password' => Hash::make('password'), // Use a strong password in production!
            'role' => 'manager', // Set the role to 'manager'
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->command->info('Admin and Manager users created successfully!');
    }
}
