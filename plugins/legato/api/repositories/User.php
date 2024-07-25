<?php

namespace Legato\Api\Repositories;

use Backend\Facades\BackendAuth;
use Backend\Models\User as UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
use Legato\Api\Classes\UserService;
use Legato\Api\Exceptions\ForbiddenException;
use Legato\Api\Exceptions\NotFoundException;
use Legato\Api\Models\Settings;
use Legato\Api\Schemas\UserSchema;

class User
{
    public const USER_NAME_LOGIN_KEY = 'login';
    public const EMAIL_LOGIN_KEY = 'email';

    protected Token $tokenRepository;

    /**
     * Auth constructor.
     * @param Token|null $tokenRepository
     */
    public function __construct(Token $tokenRepository = null)
    {
        if (!$tokenRepository) {
            $tokenRepository = new Token();
        }
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * @param string $value
     * @param string $domain
     * @return string
     */
    public function generateTempEmail(string $value, string $domain = null): string
    {
        $domain = $domain ?: Config::get('legato.api::temp_email_domain');
        return md5($value) . $domain;
    }

    /**
     * @param string $socialIdentity
     * @return mixed
     */
    public function findUserBySocialIdentity(string $socialIdentity)
    {
        return UserModel::where('social_identity', $socialIdentity)->first();
    }

    /**
     * Supporting get user info by username or email
     *
     * @param $user
     * @return mixed
     */
    public function getUserInfo($user)
    {
        if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
            $user = UserModel::where(self::EMAIL_LOGIN_KEY, $user);
        } else {
            $user = UserModel::where(self::USER_NAME_LOGIN_KEY, $user);
        }

        return $user->first();
    }

    /**
     * @param int $userId
     * @return void
     * @throws \Exception
     */
    public function forceLogout(int $userId): void
    {
        try {
            $this->tokenRepository->deleteById($userId);
        } catch (\Exception $e) {
        }
    }

    /**
     * @param array $params
     *      required string $params['user']
     *      required string $params['password']
     *      optional bool $params['remember'] = true
     * @return array
     */
    public function apiLogin(array $params): array
    {
        Event::fire('legato.api.login.before', [&$params]);

        $remember = $params['remember'] ?? true;

        // Check username and password
        $user = $this->getUserInfo($params['user']);
        if (!$user || !$user->checkPassword($params['password'])) {
            throw new ForbiddenException(Lang::get('legato.api::lang.auth.login.fail'));
        }

        if (!$user->is_activated && (bool) Settings::get('validate_activate')) {
            throw new ForbiddenException(Lang::get('legato.api::lang.auth.login.inactive'));
        }

        $tokenModel = $this->tokenRepository->generateToken($user->getKey());
        UserService::loginWithToken($tokenModel->token, $remember);

        $result = UserSchema::user($user, $tokenModel);

        Event::fire('legato.api.login.after', [$user, &$result, $tokenModel]);

        return $result;
    }

    /**
     * @param Request $request
     * @throws NotFoundException
     */
    public function apiLogout(Request $request): void
    {
        $user = BackendAuth::getUser();
        if (!$user) {
            throw new NotFoundException(Lang::get('legato.api::lang.auth.error.user_not_found'));
        }

        Event::fire('legato.api.logout');

        $this->tokenRepository->delete($request->input('token'));
    }

    /**
     * @param array $params
     *      - user: required <br>
     *      - password: required <br>
     *      - password_confirmation: required <br>
     *      <br>
     *      - email: optional <br>
     *      - first_name: optional <br>
     *      - last_name: optional <br>
     */
    public function apiRegister(array $params): void
    {
        Event::fire('legato.api.register.before', [&$params]);

        // Save user into backend_users table
        $userParams = [
            'login' => $params['user'],
            'password' => $params['password'],
            'password_confirmation' => $params['password_confirmation'],

            'email' => !empty($params['email']) ? $params['email'] : $this->generateTempEmail($params['user']),
            'first_name' => !empty($params['first_name']) ? $params['first_name'] : '',
            'last_name' => !empty($params['last_name']) ? $params['last_name'] : '',
        ];
        $user = BackendAuth::register($userParams);

        Event::fire('legato.api.register.after', [$user, &$result]);
    }

    public function apiPasswordChange(array $params)
    {
        Event::fire('legato.api.password-change.before', [&$params]);

        //TODO: Save user into backend_users table
        $user = [];

        Event::fire('legato.api.password-change.after', [$user, &$result]);

        return $result;
    }

    public function apiPasswordForgot(array $params)
    {
        Event::fire('legato.api.password-forgot.before', [&$params]);

        //TODO: Save user into backend_users table
        $user = [];

        Event::fire('legato.api.password-forgot.after', [$user, &$result]);

        return $result;
    }

    public function apiPasswordReset(array $params)
    {
        Event::fire('legato.api.password-reset.before', [&$params]);

        //TODO: Save user into backend_users table
        $user = [];

        Event::fire('legato.api.password-reset.after', [$user, &$result]);

        return $result;
    }

    public function apiVerificationCheck(array $params)
    {
        Event::fire('legato.api.verification-check.before', [&$params]);

        //TODO: Save user into backend_users table
        $user = [];

        Event::fire('legato.api.verification-check.after', [$user, &$result]);

        return $result;
    }

    public function apiVerificationSend(array $params)
    {
        Event::fire('legato.api.verification-send.before', [&$params]);

        //TODO: Save user into backend_users table
        $user = [];

        Event::fire('legato.api.verification-send.after', [$user, &$result]);

        return $result;
    }
}
