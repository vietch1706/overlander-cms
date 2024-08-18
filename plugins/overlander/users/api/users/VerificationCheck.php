<?php

namespace Overlander\Users\Api\Users;

use Illuminate\Http\Request;
use Legato\Api\Helpers\RestHelper;

class VerificationCheck extends AbstractUsers
{
    public function __invoke(Request $request): array
    {
        $params = $request->all();
        RestHelper::validate($params, [
            'user' => 'required',
            'code' => 'required|numeric',
        ]);

        return $this->users->checkCode($params['user'], $params['code']);
    }
}
