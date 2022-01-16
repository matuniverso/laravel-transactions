<?php

use App\Models\User;

use function Pest\Laravel\post;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->response = post('/api/add-balance', [
        'user_id' => $this->user->id,
        'amount' => $this->amount = 1_000_000
    ]);
});

it('has add-balance', fn () => $this->response->assertStatus(200));

it('should add balance amount', function () {
    expect($this->user->balance())
        ->toBe($this->amount);
});
