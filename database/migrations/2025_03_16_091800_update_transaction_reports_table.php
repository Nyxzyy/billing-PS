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
        Schema::table('transaction_reports', function (Blueprint $table) {
            // Rename cashier_id to user_id for consistency
            $table->renameColumn('cashier_id', 'user_id');
            
            // Rename package_type to package_name for clarity
            $table->renameColumn('package_type', 'package_name');
            
            // Change package_time to integer to store minutes
            $table->integer('package_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_reports', function (Blueprint $table) {
            $table->renameColumn('user_id', 'cashier_id');
            $table->renameColumn('package_name', 'package_type');
            $table->string('package_time', 20)->nullable()->change();
        });
    }
};
