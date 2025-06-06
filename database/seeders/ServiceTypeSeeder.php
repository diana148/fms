<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceType;

class ServiceTypeSeeder extends Seeder
{
    public function run()
{
    ServiceType::create([
        'name' => 'GPS Tracking',
        'description' => 'Real-time GPS vehicle tracking system',
        'installation_price_tzs' => 250000,
        'installation_price_usd' => 100,
        'monthly_price_tzs' => 50000,
        'monthly_price_usd' => 20,
    ]);

    ServiceType::create([
        'name' => 'Fuel Monitoring',
        'description' => 'Fuel consumption tracking and monitoring',
        'installation_price_tzs' => 400000,
        'installation_price_usd' => 160,
        'monthly_price_tzs' => 75000,
        'monthly_price_usd' => 30,
    ]);

    ServiceType::create([
        'name' => 'Dash Camera',
        'description' => 'Dashboard camera installation and monitoring',
        'installation_price_tzs' => 300000,
        'installation_price_usd' => 120,
        'monthly_price_tzs' => 25000,
        'monthly_price_usd' => 10,
    ]);
}


}
