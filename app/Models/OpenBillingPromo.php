<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenBillingPromo extends Model
{
    use HasFactory;

    protected $table = 'open_billing_promos';
    protected $fillable = ['min_hours', 'min_minutes', 'discount_price'];
}
