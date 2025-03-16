<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashierReport extends Model
{
    use HasFactory;

    protected $table = 'cashier_reports';
    protected $fillable = ['cashier_id', 'shift_start', 'shift_end', 'total_transactions', 'total_revenue', 'total_work_hours', 'work_date'];

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }
}
