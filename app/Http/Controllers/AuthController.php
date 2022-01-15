<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreAuthRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __invoke(StoreAuthRequest $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
