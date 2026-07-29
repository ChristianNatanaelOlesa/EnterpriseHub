<?php

namespace App\Services\Security;

use App\Models\Security\ScUser;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function attempt(string $username, string $password): bool
    {
        $user = ScUser::query()
            ->where('Username', $username)
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->first();

        if (!$user) {
            return false;
        }

        if (!Hash::check($password, $user->Password)) {
            return false;
        }

        session([
            'user' => $user,
        ]);

        return true;
    }

    public function logout(): void
    {
        session()->forget('user');
    }
}
