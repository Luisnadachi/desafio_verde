<?php

namespace App\Observers;

use App\Models\Wallet;
use Ramsey\Uuid\Uuid;

class WalletObserver
{

    public function creating(Wallet $wallet): void
    {
        $wallet->id = Uuid::uuid4()->toString();
    }
}
