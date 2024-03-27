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
        Schema::create('p_a_c_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('problem_animal_control_id');
            $table->unsignedBigInteger('species_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_a_c_details');
    }
};
