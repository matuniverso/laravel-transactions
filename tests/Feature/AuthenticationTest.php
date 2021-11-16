<?php

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

use function Pest\Faker\faker;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\post;

test('user can register', function () {
    $response = post('register', [
        'name' => faker()->name(),
        'email' => faker()->unique()->email(),
        'password' => '12345678',
        'password_confirmation' => '12345678'
    ]);

    $response->assertCreated();
});

test('cannot register if wrong password confirmation', function () {
    $response = post('register', [
        'name' => faker()->name(),
        'email' => faker()->unique()->email(),
        'password' => '12345678',
        'password_confirmation' => '87654321'
    ]);

    $response->assertInvalid();
});

test('user can login', function () {
    $user = User::factory()->create();

    $response = post('login', [
        'email' => $user->email,
        'password' => '12345678'
    ]);

    $response->assertSee('Authenticated');
    assertAuthenticated();
});

test('user can logout', function () {
    /** @var Authenticatable */
    $user = User::factory()->create();

    actingAs($user);

    $response = post('logout');
    $response->assertSee('Logged out');
    $response->assertOk();
});
