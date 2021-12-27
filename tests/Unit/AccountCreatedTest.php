<?php

use App\Models\User;

use function Pest\Faker\faker;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

test('an account is created after register', function () {
    post('register', [
        'name' => faker()->name(),
        'email' => $email = faker()->unique()->email(),
        'password' => '12345678',
        'password_confirmation' => '12345678'
    ]);

    $user = User::query()
        ->where('email', $email)
        ->first();

    assertDatabaseHas('accounts', [
        'user_id' => $user->id
    ]);
});
