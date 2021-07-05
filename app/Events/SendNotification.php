<?php

namespace App\Events;

use App\Models\Transaction as ModelsTransaction;

class SendNotification extends Event
{
    /**
     * @var Transaction
     */
    public $transaction;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ModelsTransaction $transaction)
    {
        $this->transaction = $transaction;
    }
}
