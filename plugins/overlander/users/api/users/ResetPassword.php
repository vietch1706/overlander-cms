<?php

namespace Overlander\Users\Api\Users;

use Illuminate\Http\Request;
use Legato\Api\Helpers\RestHelper;
use Overlander\Users\Repository\ApiUserRepository;
use Legato\Api\Api\AuthPasswordReset as ApiPasswordReset;

class ResetPassword extends ApiPasswordReset
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
            'user' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        return $this->userRepository->apiPasswordReset($params);
    }
}
