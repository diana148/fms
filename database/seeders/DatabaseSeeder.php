<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call your existing seeders
        $this->call([
            UserSeeder::class,
            ServiceTypeSeeder::class,
        ]);
    }
}
