<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingOpen extends Model
{
    use HasFactory;

    protected $table = 'billing_open';
    protected $fillable = ['price_per_hour', 'minute_count', 'price_per_minute'];
}
