<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\LogActivity;

class LogLoginActivity
{
    public function handle(Login $event)
    {
        LogActivity::create([
            'timestamp'  => now(),
            'user_id'    => $event->user->id,
            'activity'   => 'User logged in',
        ]);
    }
}
