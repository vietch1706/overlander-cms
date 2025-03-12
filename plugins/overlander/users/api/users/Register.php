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
            'phone' => ['required', 'numeric', 'regex:/[0-9]/', 'not_regex:/[a-z]/', 'unique:backend_users,phone'],
            'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'country' => 'required',
            'email' => ['required', 'email', 'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', 'unique:backend_users,email'],
        ]);
        $lang = !empty(Input::get('lang')) ? Input::get('lang') : 'zh-hk';
        $param['lang'] = $lang;
        $param['mail_receive'] = $param['mail_receive'] === 'true';
        $param['e_newsletter'] = $param['e_newsletter'] === 'true';
        $this->userRepository->apiRegister($param);
    }
}
