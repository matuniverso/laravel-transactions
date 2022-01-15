<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBalanceRequest;
use App\Http\Resources\AccountResource;
use App\Models\User;

class AddBalanceController extends Controller
{
    public function __invoke(StoreBalanceRequest $request)
    {
        $request->validated();

        /** @var User $user */
        $user = User::find($request->user_id);

        $user->setBalance($request->amount);

        return response()->json(new AccountResource($user));
    }
}
