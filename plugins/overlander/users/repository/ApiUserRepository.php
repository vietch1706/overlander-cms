<?php

namespace Overlander\Users\Repository;

use Backend\Facades\BackendAuth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
use Legato\Api\Classes\UserService;
use Legato\Api\Exceptions\BadRequestException;
use Legato\Api\Exceptions\ForbiddenException;
use Legato\Api\Exceptions\NotFoundException;
use Legato\Api\Models\Settings;
use Legato\Api\Models\Tokens;
use Legato\Api\Repositories\Token;
use Legato\Api\Repositories\User as ApiRepository;
use Overlander\General\Models\Countries;
use Overlander\General\Models\Interests;
use Overlander\Users\Models\Users as UserModel;

class ApiUserRepository extends ApiRepository
{

    protected Token $tokenRepository;
    protected $userRepository;
    protected Countries $countries;
    protected Interests $interests;

    public function __construct(
        Token     $tokenRepository,
        Users     $userRepository,
        Countries $country,
        Interests $interest,
    )
    {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
        $this->countries = $country;
        $this->interests = $interest;
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
            throw new ForbiddenException(Lang::get('overlander.users::lang.user.login.failed'));

        }

        if (!$user || !$user->checkPassword($params['password'])) {
            throw new ForbiddenException(Lang::get('overlander.users::lang.user.login.wrong'));
        }

        if ((!$user->is_activated && (bool)Settings::get('validate_activate'))) {
            throw new ForbiddenException(Lang::get('legato.api::lang.auth.login.inactive'));
        }

        $tokenModel = $this->tokenRepository->generateToken($user->getKey());
        UserService::loginWithToken($tokenModel->token, $remember);

        $result = $this->convertUserWithToken($user, $tokenModel, $params['lang']);

        Event::fire('legato.api.login.after', [$user, &$result, $tokenModel, $params]);

        return $result;
    }

    public function convertUserWithToken($user, ?Tokens $tokenModel, $lang): array
    {
        return [
            'token' => $tokenModel->token ?? null,
            'user' => $this->userRepository->convertData($user, $lang),
        ];
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

    /**
     * @param array $params
     * @throws ForbiddenException
     */
    public function apiRegister(array $params): void
    {
        $user = new UserModel();
        $params['interests'] = implode(",", $params['interests']);
        Event::fire('legato.api.register.before', [&$params]);
        // Save user into backend_users table
        $user->login = str_random(10);
        $user->first_name = $params['first_name'];
        $user->last_name = $params['last_name'];
        $user->phone = $params['phone'];
        $user->phone_area_code = $params['phone_area_code'];
        $user->password = $params['password'];
        $user->password_confirmation = $params['password_confirmation'];
        $user->email = $params['email'];
        $user->country_id = $this->countries->where('country', $params['country'])->first()['id'];
        $user->month = $params['month'] === "" ? '1' : $params['month'];
        $user->year = $params['year'] === "" ? ((int)Carbon::now()->format('Y')) : $params['year'];
        $user->gender = $params['gender'] === "" ? null : $params['gender'];
        $user->mail_receive = $params['mail_receive'];
        $user->e_newsletter = $params['e_newsletter'];
        $user->interests = $params['interests'];
        $user->join_date = Carbon::now()->format('Y-m-d');
        $user->validity_date = Carbon::now()->addMonth(3)->format('Y-m-d');
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        try {
            $user->save();
        } catch (BadRequestException $th) {
            throw new BadRequestException(Lang::get('overlander.users::lang.user.register.failed'));
        }
        Event::fire('legato.api.register.after', [$user, &$result]);
    }

    public function apiPasswordReset(array $params): array
    {
        Event::fire('legato.api.password-reset.before', [&$params]);

        if ($params['password'] == $params['password_confirmation']) {
            $user = UserModel::where('email', $params['user'])->first();
            $user->password = $params['password'];
            $user->save();
        } else {
            throw new BadRequestException(Lang::get('overlander.users::lang.user.reset.failed'));
        }
        return [
            'message' => Lang::get('overlander.users::lang.user.reset.success'),
        ];
    }

    public function apiPasswordChange($params): array
    {
        $user = UserModel::where('email', $params['user'])->first();
        if (!$user || !$user->id) {
            // Login by phone
//            $user = UserModel::where('phone', $params['user'])->where('phone_area_code', $params['phone_area_code'])->first();
//            Login by email
            throw new ForbiddenException(Lang::get('overlander.users::lang.user.change_password.failed'));
        }
        if (!$user || !$user->checkPassword($params['password'])) {
            throw new ForbiddenException(Lang::get('overlander.users::lang.user.change_password.wrong'));
        }

        if ((!$user->is_activated && (bool)Settings::get('validate_activate'))) {
            throw new ForbiddenException(Lang::get('legato.api::lang.auth.login.inactive'));
        }
        return [
            'message' => Lang::get('overlander.users::lang.user.change_password.success'),
        ];
    }
}
