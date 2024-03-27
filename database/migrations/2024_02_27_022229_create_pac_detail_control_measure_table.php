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
        Schema::create('pac_detail_control_measure', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pac_detail_id');
            $table->unsignedBigInteger('control_measure_id');
            $table->integer('male_count')->nullable();
            $table->integer('female_count')->nullable();
            $table->string('location')->nullable(); // Updated field name
            $table->decimal('latitude')->nullable();
            $table->decimal('longitude')->nullable();
            $table->longText('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pac_detail_control_measure');
    }
};
