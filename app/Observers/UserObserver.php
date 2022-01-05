<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        Account::create([
            'id' => Str::uuid()->toString(),
            'user_id' => $user->id
        ]);
    }
}
