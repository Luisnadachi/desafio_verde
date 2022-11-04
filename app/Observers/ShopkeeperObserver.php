<?php

namespace App\Observers;

use App\Models\Shopkeeper;
use Ramsey\Uuid\Uuid;

class ShopkeeperObserver
{
    public function creating(Shopkeeper $shopkeeper): void
    {
        $shopkeeper->id = Uuid::uuid4()->toString();
    }
}
