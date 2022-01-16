<?php

use App\Models\Transaction;

use function Pest\Laravel\get;

it('has list-transactions')
    ->get('/api/list-transactions')
    ->assertOk();

it('lists transactions successfully', function () {
    Transaction::factory(3)->create();

    get('/api/list-transactions')
        ->assertJsonCount(3)
        ->assertJsonStructure([
            [
                'amount',
                'payer',
                'receiver',
                'created_at',
            ]
        ]);
});
