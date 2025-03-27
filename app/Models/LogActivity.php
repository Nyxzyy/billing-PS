<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    protected $table = 'log_activity';
    protected $fillable = ['timestamp', 'user_id', 'device_id', 'transaction_id', 'activity'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function transaction()
    {
        return $this->belongsTo(TransactionReport::class, 'transaction_id');
    }
}
