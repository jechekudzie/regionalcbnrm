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
        Schema::create('ward_quota_distributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quota_request_id');
            $table->unsignedBigInteger('ward_id');
            $table->integer('hunting_quota')->nullable();
            $table->integer('pac_quota')->nullable();
            $table->integer('rational_quota')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ward_quota_distributions');
    }
};
