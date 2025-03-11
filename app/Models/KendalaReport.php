<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendalaReport extends Model
{
    use HasFactory;

    protected $table = 'kendala_report';
    protected $fillable = ['cashier_id', 'device_id', 'issue', 'time', 'date', 'status'];

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
