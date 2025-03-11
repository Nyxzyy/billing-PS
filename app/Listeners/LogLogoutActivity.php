<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\LogActivity;

class LogLogoutActivity
{
    public function handle(Logout $event)
    {
        if ($event->user) {
            LogActivity::create([
                'timestamp'  => now(),
                'user_id'    => $event->user->id,
                'activity'   => 'User logged out',
            ]);
        }
    }
}
