<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(RoleSeeder::class); 
        $this->call(UserSeeder::class);
        $this->call(BillingPackageSeeder::class);
        $this->call(DeviceSeeder::class);
    }
}
