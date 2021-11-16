<?php

use App\Actions\Auth\Login;
use App\Actions\Auth\Logout;
use App\Actions\Auth\Register;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post(
        uri: 'login',
        action: Login::class
    )->name('login');

    Route::post(
        uri: 'register',
        action: Register::class
    )->name('register');
});

Route::middleware('auth')->group(function () {
    Route::post(
        uri: 'logout',
        action: Logout::class
    )->name('logout');
});
