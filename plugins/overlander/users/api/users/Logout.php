<?php

namespace Overlander\Users\Api\Users;

use Illuminate\Http\Request;
use Legato\Api\Api\AuthLogout as ApiLogout;
use Legato\Api\Helpers\RestHelper;
use October\Rain\Support\Facades\Input;
use Overlander\Users\Repository\ApiUserRepository;

class Logout extends ApiLogout
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

    public function __invoke(Request $request)
    {
        $data = $request->all();
        $lang = !empty(Input::get('lang')) ? Input::get('lang') : 'zh-hk';
        $data['lang'] = $lang;
        $result = $this->userRepository->apiLogout($request);
        return $result;
    }
}
