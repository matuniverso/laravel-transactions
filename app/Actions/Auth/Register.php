<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;

class Register
{
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        return response()->json($user, Response::HTTP_CREATED);
    }
}
