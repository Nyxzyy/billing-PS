<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\TransactionCreated;

class TransactionReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_id',
        'package_name',
        'package_time',
        'start_time',
        'end_time',
        'total_price',
        'status',
        'original_price',
        'discount_amount'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'package_time' => 'integer',
        'total_price' => 'decimal:2'
    ];

    protected static function booted()
    {
        static::created(function ($transaction) {
            event(new TransactionCreated($transaction));
        });
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
