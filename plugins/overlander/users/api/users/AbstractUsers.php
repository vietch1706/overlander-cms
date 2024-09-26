<?php

namespace Overlander\Users\Api\Users;

use Overlander\Users\Repository\ApiUserRepository;
use Overlander\Users\Repository\Users as RepositoryUsers;

class AbstractUsers
{
    public RepositoryUsers $users;
    public ApiUserRepository $apiUserRepository;
    public function __construct(RepositoryUsers $user, ApiUserRepository $apiUserRepository)
    {
        $this->users = $user;
        $this->apiUserRepository = $apiUserRepository;
    }
}
