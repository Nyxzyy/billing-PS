<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'devices';
    protected $fillable = ['name', 'ip_address', 'location', 'status', 'shutdown_time', 'last_used_at'];

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
