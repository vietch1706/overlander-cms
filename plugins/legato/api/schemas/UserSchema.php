<?php namespace Legato\Api\Schemas;

use Backend\Models\User;
use Legato\Api\Models\Tokens;

class UserSchema
{
    public static function user(User $user, Tokens $tokenModel): array
    {
        return [
            'token' => $tokenModel->token,
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ],
        ];
    }
}
