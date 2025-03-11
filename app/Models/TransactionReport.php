<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionReport extends Model
{
    use HasFactory;

    protected $table = 'transaction_report';
    protected $fillable = ['cashier_id', 'device_id', 'package_id', 'package_type', 'package_time', 'start_time', 'end_time', 'total_price'];

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function billingPackage()
    {
        return $this->belongsTo(BillingPackage::class, 'package_id');
    }

    public function getPackageTypeAttribute()
    {
        return $this->package_id ? $this->billingPackage->package_name : 'Open Billing';
    }
}
