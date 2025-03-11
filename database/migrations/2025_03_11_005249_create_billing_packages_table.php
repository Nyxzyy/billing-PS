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
        Schema::create('billing_packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name', 100);
            $table->integer('duration_hours');
            $table->integer('duration_minutes');
            $table->decimal('total_price', 10, 2);
            $table->set('active_days', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_packages');
    }
};
