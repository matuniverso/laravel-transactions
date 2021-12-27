<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\Account;
use Illuminate\Support\Str;

class CreateAccountForUser
{
    public function handle(UserRegistered $event)
    {
        Account::create([
            'id' => Str::uuid()->toString(),
            'user_id' => $event->user->id
        ]);
    }
}
