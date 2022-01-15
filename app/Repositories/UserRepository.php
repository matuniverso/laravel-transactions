<?php

namespace App\Repositories;

use App\Models\User;

final class UserRepository
{
    public function addMoney(User $user, int $amount): bool
    {
        return $user->account->update([
            'balance' => $user->balance + $amount
        ]);
    }

    public function removeMoney(User $user, int $amount): bool
    {
        return $user->account->update([
            'balance' => $user->balance - $amount
        ]);
    }
}
