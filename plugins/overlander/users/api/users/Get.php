<?php

namespace Overlander\Users\Api\Users;

use Illuminate\Http\Request;
use Legato\Api\Helpers\RestHelper;

class Get extends AbstractUsers
{

    public function __invoke()
    {

        return $this->users->getUser();
    }
}
