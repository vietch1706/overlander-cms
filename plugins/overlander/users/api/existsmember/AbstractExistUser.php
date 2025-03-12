<?php

namespace Overlander\Users\Api\ExistsMember;

use Overlander\Users\Repository\ExistUsers as RepositoryExistUsers;
use Overlander\Users\Repository\Users as RepositoryUsers;

class AbstractExistUser
{
    public RepositoryExistUsers $existUsers;

    public function __construct(RepositoryExistUsers $existUser)
    {
        $this->existUsers = $existUser;
    }

}
