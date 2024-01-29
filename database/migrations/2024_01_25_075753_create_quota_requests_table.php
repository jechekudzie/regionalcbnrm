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
            $table->unsignedBigInteger('hunting_concession_id');
            $table->unsignedBigInteger('species_id');
            $table->integer('year');
            $table->integer('initial_quota')->nullable(); // Requested by the hunting concession
            $table->integer('rdc_quota')->nullable(); // Adjusted/approved by the RDC
            $table->integer('campfire_quota')->nullable(); // Adjusted/approved by the Campfire Committee
            $table->integer('zimpark_station_quota')->nullable(); // Adjusted/approved by the Zimpark Station
            $table->integer('national_park_quota')->nullable(); // Final quota set by the National Park
            $table->integer('available_quota')->nullable(); // available quota
            $table->string('status')->nullable(); // Tracks the current status of the quota request
            $table->string('slug'); //slug
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
