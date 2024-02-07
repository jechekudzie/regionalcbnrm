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
        Schema::table('hunting_detail_out_comes', function (Blueprint $table) {
            //professional hunter string
            $table->string('professional_hunter')->nullable()->after('hunter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hunting_detail_out_comes', function (Blueprint $table) {
            //
        });
    }
};
