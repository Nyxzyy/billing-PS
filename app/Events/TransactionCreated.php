<?php

namespace App\Events;

use App\Models\TransactionReport;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionCreated
{
    use Dispatchable, SerializesModels;

    public $transaction;

    public function __construct(TransactionReport $transaction)
    {
        $this->transaction = $transaction;
    }
}
