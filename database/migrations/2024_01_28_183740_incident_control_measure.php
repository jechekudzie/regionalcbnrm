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
        Schema::create('incident_control_measure', function (Blueprint $table) {
            $table->unsignedBigInteger('incident_id');
            $table->unsignedBigInteger('control_measure_id');

            // Setting the composite primary key
            $table->primary(['incident_id', 'control_measure_id']);

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
