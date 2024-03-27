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
        Schema::create('project_testimonials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('description')->nullable(); // 'image' or 'video'
            $table->string('testimonial_type')->nullable(); // 'image' or 'video'
            $table->string('path')->nullable();
            $table->string('date')->nullable();
            $table->string('testimonial_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_testimonials');
    }
};
