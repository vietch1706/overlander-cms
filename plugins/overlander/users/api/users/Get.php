<?php

namespace Overlander\Users\Api\Users;


class Get extends AbstractUsers
{

    public function __invoke()
    {
        return $this->users->getUser();
    }
}
