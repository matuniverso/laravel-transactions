<?php

namespace App\Http\Requests;

use App\Rules\Enough;
use App\Rules\NotShopkeeper;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => ['required', 'bail', 'integer', 'min:1', new Enough],
            'payer_id' => [
                'bail',
                'required',
                'exists:users,id',
                'different:receiver_id',
                new NotShopkeeper
            ],
            'receiver_id' => ['required', 'bail', 'exists:users,id']
        ];
    }
}
