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
        //
        Schema::create('poaching_incident_species', function (Blueprint $table) {
            $table->unsignedBigInteger('poaching_incident_id');
            $table->unsignedBigInteger('species_id');
            $table->integer('male_count')->nullable();
            $table->integer('female_count')->nullable();
            $table->primary(['poaching_incident_id', 'species_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
