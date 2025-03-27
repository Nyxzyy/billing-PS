<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\LogLoginActivity;
use App\Listeners\LogLogoutActivity;
use App\Events\DeviceStatusChanged;
use App\Listeners\LogDeviceStatusChange;
use App\Events\TransactionCreated;
use App\Listeners\LogTransactionActivity;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            LogLoginActivity::class,
        ],
        Logout::class => [
            LogLogoutActivity::class,
        ],
        DeviceStatusChanged::class => [
            LogDeviceStatusChange::class,
        ],
        TransactionCreated::class => [
            LogTransactionActivity::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
