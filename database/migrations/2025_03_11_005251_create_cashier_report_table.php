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
        Schema::create('cashier_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashier_id')->constrained('users');
            $table->dateTime('shift_start');
            $table->dateTime('shift_end')->nullable();
            $table->integer('total_transactions');
            $table->decimal('total_revenue', 10, 2);
            $table->integer('total_work_hours');
            $table->date('work_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashier_report');
    }
};
