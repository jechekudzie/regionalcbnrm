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
        Schema::create('incident_species', function (Blueprint $table) {
            $table->unsignedBigInteger('incident_id');
            $table->unsignedBigInteger('species_id');
            $table->integer('male_count')->nullable();
            $table->integer('female_count')->nullable();
            // Setting the composite primary key
            $table->primary(['incident_id', 'species_id']);

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
