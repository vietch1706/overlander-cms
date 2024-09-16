<?php

namespace Legato\Api\Repositories;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Legato\Api\Exceptions\NotFoundException;
use Legato\Api\Models\Tokens;

class Token
{
    /**
     * @param int $userId
     * @return string
     * @throws NotFoundException
     */
    public function getLatestTokenByUser(int $userId): string
    {
        $token = Tokens::byUser($userId)
            ->orderBy('created_at', 'DESC')
            ->first();

        if (!$token) {
            throw new NotFoundException(Lang::get('legato.api::lang.auth.error.token_not_found'));
        }

        return $token;
    }

    public function getAllTokensByUser(
        int $userId,
        string $orderType = Tokens::ORDER_TYPE_LAST_ACTIVE,
        string $orderBy = 'ASC'
    ) {
        return Tokens::byUser($userId)
            ->orderBy($orderType, $orderBy)
            ->get();
    }

    /**
     * @param int $userId
     * @return Tokens
     */
    public function generateToken(int $userId): Tokens
    {
        do {
            $token = $this->generateTokenString();
        }
        while (Tokens::token('token', $token)->first());

        $tokens = new Tokens();
        $tokens->user_id = $userId;
        $tokens->token = $token;

        $tokens->save();

        return $tokens;
    }

    /**
     * @param string $token
     * @return null|Tokens
     */
    public function loadByToken(string $token): ?Tokens
    {
        return Tokens::token($token)
            ->first();
    }

    /**
     * @param string $token
     * @return bool
     * @throws Exception
     */
    public function delete(string $token): bool
    {
        $tokensModel = $this->loadByToken($token);
        if ($tokensModel) {
            return $tokensModel->delete();
        }

        return false;
    }

    /**
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function deleteById(int $id): void
    {
        Tokens::where('user_id', $id)->delete();
    }

    /**
     * @param int $length
     * @return string
     */
    protected function generateTokenString(int $length = 42): string
    {
        return Str::random($length);
    }
}
