<?php

namespace Overlander\Users\Api\Users;

use Illuminate\Http\Request;
use Legato\Api\Api\AuthLogin as ApiLogin;
use Legato\Api\Helpers\RestHelper;
use October\Rain\Support\Facades\Input;
use Overlander\Users\Repository\ApiUserRepository;

class Login extends ApiLogin
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

    public function __invoke(Request $request): array
    {
        $data = $request->all();
        RestHelper::validate($data, [
            'user' => 'required',
            'password' => 'required',
//            'phone_area_code' => 'required|numeric|regex:/[0-9]/|not_regex:/[a-z]/',
        ]);

        $lang = !empty(Input::get('lang')) ? Input::get('lang') : 'zh-hk';

        $data['lang'] = $lang;

        $result = $this->userRepository->apiLogin($data);

        return $result;
    }
}
