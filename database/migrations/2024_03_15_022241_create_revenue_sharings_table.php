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
        Schema::create('revenue_sharings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payable_item_id');
            $table->unsignedBigInteger('organisation_id');
            $table->decimal('percentage_share', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenue_sharings');
    }
};
