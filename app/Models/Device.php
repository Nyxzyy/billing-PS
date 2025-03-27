<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\DeviceStatusChanged;

class Device extends Model
{
    use HasFactory;

    protected $table = 'devices';
    protected $fillable = [
        'name',
        'ip_address',
        'location',
        'status',
        'package',
        'shutdown_time',
        'last_used_at'
    ];

    protected $casts = [
        'shutdown_time' => 'datetime',
        'last_used_at' => 'datetime'
    ];

    protected $dates = [
        'shutdown_time',
        'last_used_at'
    ];

    protected static function booted()
    {
        static::updating(function ($device) {
            if ($device->isDirty('status')) {
                event(new DeviceStatusChanged(
                    $device,
                    $device->getOriginal('status'),
                    $device->status
                ));
            }
        });
    }

    public function kendalaReports()
    {
        return $this->hasMany(KendalaReport::class);
    }

    public function transactionReports()
    {
        return $this->hasMany(TransactionReport::class);
    }

    public function logActivities()
    {
        return $this->hasMany(LogActivity::class);
    }
}
