<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // GPS Tracking, Fuel Tracking, Dash Camera
            $table->text('description')->nullable();
            $table->decimal('installation_price_tzs', 10, 2);
            $table->decimal('installation_price_usd', 10, 2);
            $table->decimal('monthly_price_tzs', 10, 2);
            $table->decimal('monthly_price_usd', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_types');
    }
};
