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
        Schema::create('hunting_activity_vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hunting_activity_id');
            $table->string('vehicle_type')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('driver')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hunting_activity_vehicles');
    }
};
