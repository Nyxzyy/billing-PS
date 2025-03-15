<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Device;
use Carbon\Carbon;

class DeviceSeeder extends Seeder
{
    public function run()
    {
        $devices = [
            ['name' => 'Device 1', 'ip_address' => '192.168.1.1', 'location' => 'Ruang Server', 'status' => 'Tersedia'],
            ['name' => 'Device 2', 'ip_address' => '192.168.1.2', 'location' => 'Lantai 1', 'status' => 'Tersedia'],
            ['name' => 'Device 3', 'ip_address' => '192.168.1.3', 'location' => 'Lantai 2', 'status' => 'Tersedia'],
            ['name' => 'Device 4', 'ip_address' => '192.168.1.4', 'location' => 'Lantai 3', 'status' => 'Tersedia'],
            ['name' => 'Device 5', 'ip_address' => '192.168.1.5', 'location' => 'Gudang', 'status' => 'Tersedia'],
            ['name' => 'Device 6', 'ip_address' => '192.168.1.6', 'location' => 'Ruang IT', 'status' => 'Tersedia'],
            ['name' => 'Device 7', 'ip_address' => '192.168.1.7', 'location' => 'Lobby', 'status' => 'Tersedia'],
            ['name' => 'Device 8', 'ip_address' => '192.168.1.8', 'location' => 'Kantor Utama', 'status' => 'Tersedia'],
            ['name' => 'Device 9', 'ip_address' => '192.168.1.9', 'location' => 'Lab', 'status' => 'Maintenance'],
            ['name' => 'Device 10', 'ip_address' => '192.168.1.10', 'location' => 'Workshop', 'status' => 'Maintenance'],
        ];

        foreach ($devices as &$device) {
            $device['last_used_at'] = Carbon::now()->subDays(rand(1, 30)); // Random 1-30 hari lalu
            Device::create($device);
        }
    }
}
