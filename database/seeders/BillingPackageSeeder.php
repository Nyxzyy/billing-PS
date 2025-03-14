<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BillingPackage;

class BillingPackageSeeder extends Seeder
{
    public function run()
    {
        $packages = [
            [
                'package_name'     => 'Paket Biasa',
                'duration_hours'   => 2,
                'duration_minutes' => 0,
                'total_price'      => 12000,
                'active_days'      => 'Senin,Selasa,Rabu,Kamis,Jumat',
            ],
            [
                'package_name'     => 'Paket Setengah Hari',
                'duration_hours'   => 6,
                'duration_minutes' => 0,
                'total_price'      => 30000,
                'active_days'      => 'Sabtu,Minggu',
            ],
            [
                'package_name'     => 'Paket Kilat',
                'duration_hours'   => 0,
                'duration_minutes' => 30,
                'total_price'      => 2500,
                'active_days'      => 'Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            ],
        ];

        foreach ($packages as $package) {
            BillingPackage::create($package);
        }
    }
}
