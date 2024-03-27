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
            $table->unsignedBigInteger('poaching_incident_id');
            $table->unsignedBigInteger('poacher_type_id');
            $table->unsignedBigInteger('offence_type_id');
            $table->unsignedBigInteger('poaching_reason_id');

            $table->string('full_name');
            $table->integer('age')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('identification_type_id')->nullable();
            $table->string('identification')->nullable();

            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->string('origin')->nullable();

            $table->string('docket_number')->nullable();

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
