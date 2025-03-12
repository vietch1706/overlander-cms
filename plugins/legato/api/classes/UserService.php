<?php

namespace Legato\Api\Classes;

use Backend\Facades\BackendAuth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Legato\Api\Models\Settings;
use Legato\Api\Repositories\Token;

/**
 * User Service
 */
class UserService
{
    public static function loginWithToken(string $token, bool $remember = true): bool
    {
        $tokenRepository = new Token();
        $tokenModel = $tokenRepository->loadByToken($token);
        if (!$tokenModel) {
            return false;
        }

        $current = strtotime(Carbon::now());
        $createdAt = strtotime($tokenModel->last_active);
        if ($createdAt + Settings::get('login_timeout') < $current) {
            $tokenModel->delete();
            return false;
        }

        $user = $tokenModel->user;
        if (empty($user)) {
            return false;
        }

        BackendAuth::login($user, $remember);

        // Update last_active value at beforeSave().
        $tokenModel->save();

        return true;
    }
}
