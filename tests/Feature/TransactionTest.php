<?php

use App\Models\User;
use Illuminate\Support\Facades\Queue;

use function Pest\Laravel\post;

beforeEach(function () {
    // Mockery
    Queue::fake();

    // Normal users
    [$this->x, $this->y] = User::factory(2)->create();
    // Give $100 to user Y
    $this->y->setBalance(100);

    // Shopkeeper user
    $this->z = User::factory()->create(['type' => 2]);
    // Give $50 to user Z
    $this->z->setBalance(50);
});

/**
 * Validations
 */
test('amount should not be less than 1', function () {
    $response = post('/api/transaction', [
        'amount' => 0,
        'payer_id' => $this->x->id,
        'receiver_id' => $this->y->id
    ]);

    $response->assertStatus(302)
        ->assertInvalid([
            'amount' => 'The amount must be at least 1.'
        ]);
});

test('should have enough balance', function () {
    $response = post('/api/transaction', [
        'amount' => 20,
        'payer_id' => $this->x->id,
        'receiver_id' => $this->y->id
    ]);

    $response->assertStatus(302)
        ->assertInvalid([
            'amount' => 'Not enough balance.'
        ]);
});

test('payer and receiver should not be the same', function () {
    $response = post('/api/transaction', [
        'amount' => 20,
        'payer_id' => $this->x->id,
        'receiver_id' => $this->x->id
    ]);

    $response->assertStatus(302)
        ->assertInvalid([
            'payer_id' => 'The payer id and receiver id must be different.'
        ]);
});

test('both payer and receiver must exist', function () {
    // payer id test
    $response = post('/api/transaction', [
        'amount' => 20,
        'payer_id' => rand(100, 999),
        'receiver_id' => $this->y->id
    ]);

    $response->assertStatus(302)
        ->assertInvalid([
            'payer_id' => 'The selected payer id is invalid.'
        ]);

    // receiver id test
    $response = post('/api/transaction', [
        'amount' => 20,
        'payer_id' => $this->x->id,
        'receiver_id' => rand(100, 999)
    ]);

    $response->assertStatus(302)
        ->assertInvalid([
            'receiver_id' => 'The selected receiver id is invalid.'
        ]);
});

test('shopkeepers must not pay other users', function () {
    expect($this->z->type)->toBe('Shopkeeper');

    $response = post('/api/transaction', [
        'amount' => 20,
        'payer_id' => $this->z->id,
        'receiver_id' => $this->x->id
    ]);

    $response->assertStatus(302)
        ->assertInvalid([
            'payer_id' => 'Shopkeepers can only receive.'
        ]);
});

/**
 * Pass transaction
 */
test('transaction actually creates', function () {
    $response = post('/api/transaction', [
        'amount' => 20,
        'payer_id' => $this->y->id,
        'receiver_id' => $this->x->id
    ]);

    $response->assertCreated()
        ->assertJsonStructure([
            'amount',
            'payer',
            'receiver',
            'created_at'
        ]);
});

test('shopkeepers can receive', function () {
    expect($this->z->type)->toBe('Shopkeeper');

    $response = post('/api/transaction', [
        'amount' => 20,
        'payer_id' => $this->y->id,
        'receiver_id' => $this->z->id
    ]);

    $response->assertCreated()
        ->assertSee(['receiver.user_type' => 'Shopkeeper']);
});

test('money is removed from payer and added to receiver', function () {
    post('/api/transaction', [
        'amount' => 75,
        'payer_id' => $this->y->id,
        'receiver_id' => $this->x->id
    ])->assertSee([
        'payer.balance' => 25,
        'receiver.balance' => 75
    ]);
});
