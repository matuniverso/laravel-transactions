<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddBalanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;

Route::middleware('guest')->group(function () {
    Route::post('/sanctum/token', AuthController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/account', AccountController::class);
});

Route::post('/transaction', [TransactionController::class, 'store']);
Route::get('/list-transactions', [TransactionController::class, 'index']);
Route::post('/add-balance', AddBalanceController::class);
