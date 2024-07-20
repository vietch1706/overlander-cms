<?php

namespace Overlander\Users\Api;

use Illuminate\Http\Request;
use Legato\Api\Api\AuthLogout as ApiLogout;
use Legato\Api\Exceptions\ForbiddenException;
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
    ) {
        parent::__construct($userRepository);
    }

    public function __invoke(Request $request): array
    {
            $result = $this->userRepository->apiLogout($data);

        return $result;
    }
}
