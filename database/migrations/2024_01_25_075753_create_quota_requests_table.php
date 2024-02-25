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
            $table->unsignedBigInteger('organisation_id');
            $table->unsignedBigInteger('species_id');
            $table->integer('year');
            $table->integer('hunting_quota')->nullable(); // For Trophy hunting concession
            $table->integer('hunting_quota_balance')->nullable(); // For Trophy hunting concession
            $table->integer('rational_quota')->nullable(); // Rational Killing hunting concession
            $table->integer('rational_quota_balance')->nullable(); // Rational Killing hunting concession
            $table->integer('zimpark_hunting_quota')->nullable(); // Adjusted/approved by the Zimpark Station
            $table->integer('zimpark_pac_quota')->nullable(); // Adjusted/approved by the Zimpark Station
            $table->integer('zimpark_rational_quota')->nullable(); //
            $table->string('status')->nullable(); // Tracks the current status of the quota request
            $table->boolean('is_approved')->default(0); // Tracks the current status of the quota request
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
