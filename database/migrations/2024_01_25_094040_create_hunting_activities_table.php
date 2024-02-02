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
        Schema::create('hunting_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hunting_concession_id');// Hunting concession in which the activity takes place
            $table->unsignedBigInteger('organisation_id'); // RDC or other
            $table->string('hunting_license')->nullable(); // Professional Hunter license
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hunting_activities');
    }
};
