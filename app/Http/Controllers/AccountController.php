<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccountResource;

class AccountController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        return response()->json(new AccountResource($user));
    }
}
