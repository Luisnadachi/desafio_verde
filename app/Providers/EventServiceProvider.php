<?php

namespace App\Providers;

use App\Models\Shopkeeper;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Observers\ShopkeeperObserver;
use App\Observers\TransactionObserver;
use App\Observers\UserObserver;
use App\Observers\WalletObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
       User::observe(UserObserver::class);
       Shopkeeper::observe(ShopkeeperObserver::class);
       Wallet::observe(WalletObserver::class);
       Transaction::observe(TransactionObserver::class);
    }
}
