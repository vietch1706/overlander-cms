<?php

namespace Overlander\Users\Api\Users;

use Illuminate\Http\Request;
use Legato\Api\Api\AuthPasswordChange as ApiPasswordChange;
use Legato\Api\Helpers\RestHelper;
use Overlander\Users\Repository\ApiUserRepository;

class ChangePassword extends ApiPasswordChange
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
        $params = $request->all();
        RestHelper::validate($params, [
            'email' => 'email|regex:/^[\w\.]+@([\w-]+\.)+[\w-]{2,4}$/',
            'current_password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'new_password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'password_confirmation' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
        ]);
        return $this->userRepository->apiPasswordChange($params);
    }
}
