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
        Schema::create('hunting_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hunting_activity_id');
            $table->unsignedBigInteger('hunting_concession_id')->nullable();
            $table->unsignedBigInteger('quota_request_id')->nullable();
            $table->unsignedBigInteger('species_id')->nullable();
            $table->integer('offtake')->nullable();
            $table->string('rbz_trastool_number')->nullable();
            $table->boolean('is_special')->default(0);
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('maturity_id')->nullable();
            $table->string('trophy_size')->nullable();
            $table->string('trophy_quality')->nullable();
            $table->string('location')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hunting_details');
    }
};
