<?php

namespace App\Observers;

use App\Models\Transaction;
use Ramsey\Uuid\Uuid;

class TransactionObserver
{

    public function creating(Transaction $transaction): void
    {
        $transaction->id = Uuid::uuid4()->toString();
    }
}
