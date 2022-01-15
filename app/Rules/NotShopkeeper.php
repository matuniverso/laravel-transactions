<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class NotShopkeeper implements Rule
{
    public function passes($attribute, $value)
    {
        $user = User::find($value);

        return $user->type !== User::SHOPKEEPER_USER;
    }

    public function message()
    {
        return 'Shopkeepers can only receive.';
    }
}
