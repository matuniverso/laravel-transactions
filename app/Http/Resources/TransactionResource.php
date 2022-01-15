<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'amount' => $this->amount,
            'payer' => new AccountResource(
                User::find($this->payer_id)
            ),
            'receiver' => new AccountResource(
                User::find($this->receiver_id)
            ),
            'date' => $this->created_at->format('d-m-Y')
        ];
    }
}
