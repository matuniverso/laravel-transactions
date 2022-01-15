<?php

namespace App\Http\Requests;

use App\Rules\Enough;
use App\Rules\NotShopkeeper;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payer_id' => [
                'bail',
                'required',
                'exists:users,id',
                'different:receiver_id',
                new NotShopkeeper
            ],
            'receiver_id' => ['bail', 'required', 'exists:users,id'],
            'amount' => ['bail', 'required', 'integer', 'min:1', new Enough],
        ];
    }
}
