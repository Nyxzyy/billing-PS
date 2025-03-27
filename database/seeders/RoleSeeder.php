<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['id' => 1, 'name' => 'Admin'],
            ['id' => 2, 'name' => 'Kasir'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['id' => $role['id']], ['name' => $role['name']]);
        }
    }
}
