<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'phone_number',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function kendalaReports()
    {
        return $this->hasMany(KendalaReport::class, 'cashier_id');
    }

    public function transactionReports()
    {
        return $this->hasMany(TransactionReport::class, 'cashier_id');
    }

    public function cashierReports()
    {
        return $this->hasMany(CashierReport::class, 'cashier_id');
    }

    public function logActivities()
    {
        return $this->hasMany(LogActivity::class);
    }
}
