<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;

class Enough implements Rule, DataAwareRule
{
    protected $data = [];

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function passes($attribute, $value)
    {
        $user = User::find($this->data['payer_id']);

        return $value <= $user->balance();
    }

    public function message()
    {
        return 'Not enough balance.';
    }
}
