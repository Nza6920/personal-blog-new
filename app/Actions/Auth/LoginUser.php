<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;

class LoginUser
{
    public function handle(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }
}
