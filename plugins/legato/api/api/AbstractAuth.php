<?php

namespace Legato\Api\Api;

use OpenApi\Annotations\Tag;
use Legato\Api\Repositories\User;

/**
 * @Tag(
 *     name="Auth",
 *     description="Authentication"
 * ),
 */
abstract class AbstractAuth
{
    /**
     * @var User
     */
    protected $userRepository;

    public function __construct(User $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
