<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\LoginRequest;

class Login
{
    public function __invoke(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response('Authenticated.');
    }
}
