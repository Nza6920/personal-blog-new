<?php

namespace App\Actions\Users;

use App\Models\User;

class UpdateUserPassword
{
    public function handle(User $user, string $password): void
    {
        $user->password = $password;
        $user->save();
    }
}
