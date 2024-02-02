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
        Schema::create('incident_poaching_methods', function (Blueprint $table) {
            $table->unsignedBigInteger('poaching_incident_id');
            $table->unsignedBigInteger('poaching_method_id');

            $table->primary(['poaching_incident_id', 'poaching_method_id']);
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