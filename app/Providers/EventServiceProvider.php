<?php

namespace App\Providers;

use App\Events\TransactionCreated;
use App\Listeners\SendTransactionNotification;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TransactionCreated::class => [
            SendTransactionNotification::class
        ]
    ];

    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
