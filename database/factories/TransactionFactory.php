<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Str::uuid()->toString(),
            'amount' => 0,
            'payer_id' => Account::factory(),
            'receiver_id' => Account::factory()
        ];
    }
}
