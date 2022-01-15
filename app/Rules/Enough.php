<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Enough implements Rule
{
    public function passes($attribute, $value)
    {
        return $value <= auth()->user()->account->balance;
    }

    public function message()
    {
        return 'Not enough balance.';
    }
}
