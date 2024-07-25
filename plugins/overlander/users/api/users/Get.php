<?php

namespace Overlander\Users\Api\Users;

use Illuminate\Http\Request;

class Get extends AbstractUsers
{

    public function __invoke(Request $request)
    {
        return $this->users->getUser();
    }
}
