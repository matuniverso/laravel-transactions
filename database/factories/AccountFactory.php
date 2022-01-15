<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'user_id' => User::factory(),
            'balance' => 0
        ];
    }
}
