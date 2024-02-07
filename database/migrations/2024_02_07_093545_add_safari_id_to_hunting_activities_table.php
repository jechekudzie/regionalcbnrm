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
        Schema::table('hunting_activities', function (Blueprint $table) {
            //add safari_id to hunting_activities table
            $table->unsignedBigInteger('safari_id')->nullable()->after('organisation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hunting_activities', function (Blueprint $table) {
            //

        });
    }
};
