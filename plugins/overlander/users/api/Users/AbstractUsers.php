<?php

namespace Overlander\Users\Api\Users;

use Overlander\Users\Repository\Users as RepositoryUsers;

class AbstractUsers
{
    public RepositoryUsers $users;

    public function __construct(RepositoryUsers $user)
    {
        $this->users = $user;
    }
}
