<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/account', AccountController::class)->name('account');

    Route::apiResource('/transactions', TransactionController::class)
        ->only(['index', 'store']);
});
