<?php

namespace App\Actions\Auth;

use App\Events\UserRegistered;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;

class Register
{
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        event(new UserRegistered($user));

        return response()->json($user, Response::HTTP_CREATED);
    }
}
