<?php

namespace App\Events;

use App\Models\Device;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeviceStatusChanged
{
    use Dispatchable, SerializesModels;

    public $device;
    public $oldStatus;
    public $newStatus;

    public function __construct(Device $device, $oldStatus, $newStatus)
    {
        $this->device = $device;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }
}
