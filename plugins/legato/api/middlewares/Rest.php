<?php

namespace Legato\Api\Middlewares;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Legato\Api\Classes\UserService;
use October\Rain\Database\ModelException;

class Rest
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $this->optionalLogin($request);

        $response = $next($request);

        return $this->response($response);
    }

    private function optionalLogin($request): void
    {
        $token = !empty($request->bearerToken()) ? $request->bearerToken() : Cookie::get('bearerToken');
        if (!$token) {
            return;
        }

        $login = UserService::loginWithToken($token);
        if (!$login) {
            return;
        }

        $request->request->add(['token' => $token]);
    }

    private function response($response): JsonResponse
    {
        $statusCode = 200;
        $message = null;
        $data = method_exists($response, 'getData') ? $response->getData() : null;
        if (!empty($response->exception)) {
            $message = $response->exception->getMessage();

            // instance of Symfony\Component\HttpKernel\Exception\HttpExceptionInterface
            if (method_exists($response->exception, 'getStatusCode')) {
                $statusCode = $response->exception->getStatusCode();
            }
            // instance of October\Rain\Database\ModelException
            elseif ($response->exception instanceof ModelException) {
                $statusCode = 400;
            }
            // instance of \Throwable
            else {
                $statusCode = $response->exception->getCode();
            }

            $statusCode = $this->validHttpErrorCode($statusCode, 500);
        }

        $output = [
            'message' => $message ?: 'OK',
            'server_time' => Carbon::now(),
        ];
        if ($data) {
            $output['data'] = $data;
        }

        Event::fire('legato.api.response.before', [&$statusCode, &$output]);
        $response =  FacadesResponse::json($output, $statusCode);
        Event::fire('legato.api.response.after', [$statusCode, $output, $response]);

        return $response;
    }

    private function validHttpErrorCode($code, int $defaultCode = 200)
    {
        if (array_key_exists($code, Response::$statusTexts)) {
            return $code;
        }

        return $defaultCode;
    }
}
