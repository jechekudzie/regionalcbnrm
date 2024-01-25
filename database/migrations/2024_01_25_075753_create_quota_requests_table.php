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
        Schema::create('quota_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('species_id');
            $table->unsignedBigInteger('organisation_id'); // Refers to the ward
            $table->integer('year');
            $table->integer('initial_quota')->nullable();
            $table->integer('rdc_quota')->nullable();
            $table->integer('campfire_quota')->nullable();
            $table->integer('zimpark_station_quota')->nullable();
            $table->integer('national_park_quota')->nullable();
            $table->string('status')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('is_approved')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quota_requests');
    }
};
