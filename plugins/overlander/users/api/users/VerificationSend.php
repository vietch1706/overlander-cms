<?php

namespace Overlander\Users\Api\Users;

use Illuminate\Http\Request;
use Legato\Api\Helpers\RestHelper;

class VerificationSend extends AbstractUsers
{
    public function __invoke(Request $request): array
    {
        $params = $request->all();
        RestHelper::validate($params, [
            'user' => 'required',
            'method' => 'required',
        ]);

        return $this->users->sendCode($params['user'], $params['method']);
    }
}
