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
        Schema::create('population_estimates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organisation_id')->nullable();
            $table->unsignedBigInteger('species_id');
            $table->unsignedBigInteger('maturity_id');
            $table->unsignedBigInteger('species_gender_id');
            $table->unsignedBigInteger('counting_method_id');
            $table->integer('year');
            $table->integer('estimate')->nullable();
            $table->integer('optimal')->nullable();
            $table->foreignId('conducted_by')->nullable();
            $table->boolean('approved')->default(0);
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('population_estimates');
    }
};
