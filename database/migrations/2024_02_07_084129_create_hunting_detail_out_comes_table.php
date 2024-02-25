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
        Schema::create('hunting_detail_out_comes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hunting_detail_id');
            $table->unsignedBigInteger('hunter_id')->nullable();
            $table->unsignedBigInteger('professional_hunter_id')->nullable();
            $table->string('professional_hunter')->nullable();
            $table->unsignedBigInteger('shot_id')->nullable();
            $table->string('location_of_shot')->nullable();
            $table->integer('number_of_shots')->nullable();
            $table->unsignedBigInteger('hunting_out_come_id')->nullable();
            $table->integer('number_of_misses')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->json('pictures')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hunting_detail_out_comes');
    }
};
