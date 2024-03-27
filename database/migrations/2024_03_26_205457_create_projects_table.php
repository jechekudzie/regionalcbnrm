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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organisation_id');
            $table->string('name');
            $table->unsignedBigInteger('project_category_id');
            $table->unsignedBigInteger('project_status_id')->default('1');
            $table->text('project_proposal')->nullable();
            $table->text('project_description')->nullable();
            $table->string('project_start_date')->nullable();
            $table->string('project_end_date')->nullable();
            $table->string('project_goals')->nullable();
            $table->string('project_funds')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
