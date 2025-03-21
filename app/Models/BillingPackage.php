<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingPackage extends Model
{
    use HasFactory;

    protected $table = 'billing_packages';
    protected $fillable = ['package_name', 'duration_hours', 'duration_minutes', 'total_price', 'active_days'];

    protected $casts = [
        'active_days' => 'array',
    ];

    public function transactionReports()
    {
        return $this->hasMany(TransactionReport::class, 'package_id');
    }
}
