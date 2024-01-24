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
        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('organisation_type_id');
            $table->unsignedBigInteger('organisation_id')->nullable();//can be child of another organisation
            $table->string('logo')->nullable();//can be child of another organisation
            $table->longText('description')->nullable();//can be child of another organisation
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
