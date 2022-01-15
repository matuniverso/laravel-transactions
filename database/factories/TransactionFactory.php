<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'amount' => rand(100, 99999),
            'payer_id' => User::factory(),
            'receiver_id' => User::factory()
        ];
    }
}
