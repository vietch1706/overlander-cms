<?php

namespace Overlander\Users\Api\Users;

use Illuminate\Http\Request;
use Legato\Api\Api\AuthRegister as ApiRegister;
use Legato\Api\Helpers\RestHelper;
use October\Rain\Support\Facades\Input;
use Overlander\Users\Repository\ApiUserRepository;

class Register extends ApiRegister
{
    /**
     * @var ApiUserRepository
     */
    protected $userRepository;

    /**
     * AuthLogin constructor.
     * @param ApiUserRepository $userRepository
     */
    public function __construct(
        ApiUserRepository $userRepository
    )
    {
        parent::__construct($userRepository);
    }

    public function __invoke(Request $request): void
    {
        $param = $request->all();
        RestHelper::validate($param, [
            'first_name' => 'required',
            'last_name' => 'required',
//            'phone' => ['required', 'unique:overlander_users_users,phone'],
            'password' => 'required',
            'country' => 'required',
//            'email' => ['required', 'email', 'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', 'unique:overlander_users_users,email'],
        ]);

        $lang = !empty(Input::get('lang')) ? Input::get('lang') : 'zh-hk';
        $param['lang'] = $lang;
        $param['mail_receive'] = $param['mail_receive'] === 'true' ? true : false;
        $param['e_newsletter'] = $param['e_newsletter'] === 'true' ? true : false;

        $this->userRepository->apiRegister($param);
//        return $this->userRepository->apiRegister($param);
    }
}
