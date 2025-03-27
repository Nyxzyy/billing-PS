<?php

namespace App\Listeners;

use App\Events\DeviceStatusChanged;
use App\Models\LogActivity;

class LogDeviceStatusChange
{
    public function handle(DeviceStatusChanged $event)
    {
        LogActivity::create([
            'timestamp'  => now(),
            'device_id' => $event->device->id,
            'activity'  => "Device '{$event->device->name}' status changed from {$event->oldStatus} to {$event->newStatus}",
        ]);
    }
}
