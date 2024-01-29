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
        Schema::create('hunting_concession_ward', function (Blueprint $table) {
            $table->unsignedBigInteger('hunting_concession_id');
            $table->unsignedBigInteger('ward_id'); // Assuming wards are also stored in the 'organisations' table

            $table->foreign('hunting_concession_id')->references('id')->on('hunting_concessions')->onDelete('cascade');
            $table->foreign('ward_id')->references('id')->on('organisations')->onDelete('cascade');

            $table->primary(['hunting_concession_id', 'ward_id']);
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
