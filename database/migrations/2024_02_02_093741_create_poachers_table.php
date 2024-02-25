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
        Schema::create('poachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age')->nullable();
            $table->string('identification')->nullable();
            $table->string('docket_number')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->string('origin')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poachers');
    }
};
