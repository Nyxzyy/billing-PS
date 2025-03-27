<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpenBillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('billing_open')->insert([
            [
                'price_per_hour' => 10000, 
                'minute_count' => 10,
                'price_per_minute' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
