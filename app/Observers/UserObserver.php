<?php

namespace App\Observers;

use App\Models\Account;
use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        Account::create([
            'user_id' => $user->id
        ]);
    }
}
