<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'role_id' => 1, 
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'phone_number' => '08123456789',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => 2,
            'name' => 'Kasir',
            'email' => 'kasir@example.com',
            'phone_number' => '08129876543',
            'password' => Hash::make('password'),
        ]);
    }
}
