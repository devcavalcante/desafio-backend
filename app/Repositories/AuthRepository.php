<?php


namespace App\Repositories;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public function authenticate(array $fields): array
    {
        $user = User::where('email', $fields['email'])->first();
        if (!$user) {
            throw new AuthorizationException('Invalid credentials', 401);
        }

        if (Hash::check($fields['password'], $user->password)) {
            $token = $user->createToken($user);
        } else {
            throw new AuthorizationException('Invalid credentials', 401);
        }
        return [
            'access_token' => $token->accessToken,
            'expires_at' => $token->token->expires_at,
            'user' => $user
        ];
    }
}
