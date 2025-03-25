<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use App\Models\LogActivity;

class LogTransactionActivity
{
    public function handle(TransactionCreated $event)
    {
        LogActivity::create([
            'timestamp' => now(),
            'device_id' => $event->transaction->device_id,
            'transaction_id' => $event->transaction->id,
            'user_id' => $event->transaction->user_id,
            'activity' => "New transaction created for device '{$event->transaction->device->name}' with package '{$event->transaction->package_name}'",
        ]);
    }
}
