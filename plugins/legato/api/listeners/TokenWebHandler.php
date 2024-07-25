<?php

namespace Legato\Api\Listeners;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;

class TokenWebHandler
{
    public function handle(int $statusCode, array $output, JsonResponse $response): void
    {
        if ($statusCode === 200
            && !empty($output['data']) && !empty($output['data']->token)
        ) {
            $response->withCookie(
                Cookie::make('bearerToken', $output['data']->token, \Config::get('legato.api::login_timeout'))
            );
        }
    }
}
