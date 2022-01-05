<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'user_type' => match ($this->type) {
                User::SHOPKEEPER_USER => 'Shopkeeper',
                default => 'Regular User'
            },
            'balance' => $this->account->balance
        ];
    }
}
