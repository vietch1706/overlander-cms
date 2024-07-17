<?php

namespace Legato\Api\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Lang;
use Legato\Api\Classes\UserService;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Auth
{
    public function handle(Request $request, Closure $next)
    {
        $challenge = Config::get('legato.api::challenge');

        $token = !empty($request->bearerToken()) ? $request->bearerToken() : Cookie::get('bearerToken');

        if (empty($token)) {
            throw new UnauthorizedHttpException($challenge, Lang::get('legato.api::lang.auth.error.auth_fail'));
        }

        $login = UserService::loginWithToken($token);
        if (!$login) {
            throw new UnauthorizedHttpException($challenge, Lang::get('legato.api::lang.auth.logout.logged_out'));
        }

        $request->request->add(['token' => $token]);

        return $next($request);
    }
}
