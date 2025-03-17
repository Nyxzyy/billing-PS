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
        Schema::table('devices', function (Blueprint $table) {
            // First drop the existing column
            $table->dropColumn('shutdown_time');
        });

        Schema::table('devices', function (Blueprint $table) {
            // Then recreate it as dateTime
            $table->dateTime('shutdown_time')->nullable()->after('package');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            // First drop the datetime column
            $table->dropColumn('shutdown_time');
        });

        Schema::table('devices', function (Blueprint $table) {
            // Then recreate it as time
            $table->time('shutdown_time')->nullable()->after('package');
        });
    }
};
