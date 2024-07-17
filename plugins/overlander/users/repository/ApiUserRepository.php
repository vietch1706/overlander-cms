<?php

namespace Overlander\Users\Repository;

use Backend\Facades\BackendAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
use Legato\Api\Classes\UserService;
use Legato\Api\Exceptions\ForbiddenException;
use Legato\Api\Exceptions\NotFoundException;
use Legato\Api\Models\Settings;
use Legato\Api\Repositories\Token;
use Legato\Api\Repositories\User as ApiRepository;
use Overlander\Users\Models\Users as UserModel;
use Legato\Api\Models\Tokens;

class ApiUserRepository extends ApiRepository
{

    protected Token $tokenRepository;

    protected $userRepository;

    public function __construct(
        Token $tokenRepository,
        Users $userRepository
    )
    {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $params
     * @return array
     * @throws ForbiddenException
     */
    public function apiLogin(array $params): array
    {
        Event::fire('legato.api.login.before', [&$params]);

        $remember = $params['remember'] ?? true;

        $user = UserModel::where('email', $params['user'])->first();

        if (!$user || !$user->id) {
            // Login by phone
//            $user = UserModel::where('phone', $params['user'])->where('phone_area_code', $params['phone_area_code'])->first();
//            Login by email
            throw new ForbiddenException(Lang::get('overlander.user::lang.user.login.wrong'));

        }

        if (!$user || !$user->checkPassword($params['password'])) {
            throw new ForbiddenException("sai nè");
        }

        if ((!$user->is_activated && (bool)Settings::get('validate_activate'))) {
            throw new ForbiddenException(Lang::get('legato.api::lang.auth.login.inactive'));
        }

//        if (!empty($user)) {
//            $devices = Device::where('user_id', $user->id)->get();
//            if (!empty($devices->first())) {
//                foreach ($devices as $device) {
//                    $push = new PushClasses();
//                    $push->removeDevice($device->token);
//                    $this->tokenRepository->delete($device->token);
//                }
//            }
//        }

        $tokenModel = $this->tokenRepository->generateToken($user->getKey());
        UserService::loginWithToken($tokenModel->token, $remember);

        $result = $this->convertUserWithToken($user, $tokenModel, $params['lang']);

        Event::fire('legato.api.login.after', [$user, &$result, $tokenModel, $params]);
        return $result;
    }

    /**
     * @param Request $request
     * @throws NotFoundException
     */
    public function apiLogout(Request $request): void
    {
        $user = BackendAuth::getUser();
        $params = $request->all();
        if (!$user) {
            throw new NotFoundException(Lang::get('legato.api::lang.auth.error.user_not_found'));
        }

        Event::fire('legato.api.logout', [$params]);

        $this->tokenRepository->delete($request->input('push_token'));
    }

    public function convertUserWithToken($user, ?Tokens $tokenModel, $lang): array
    {
        return [
            'token' => $tokenModel->token ?? null,
            'user' => $this->userRepository->convertData($user, $lang),
        ];
    }
}
