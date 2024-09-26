<?php

namespace Overlander\Users\Api\Users;

use Legato\Api\Helpers\RestHelper;
use Illuminate\Http\Request;

class UpdateByToken extends AbstractUsers
{
    public function __invoke(Request $request)
    {
        $params = $request->all();
        RestHelper::validate($params, [
            'token' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|numeric|regex:/[0-9]/|not_regex:/[a-z]/',
            'phone_area_code' => 'required|numeric',
            'district' => 'required|string',
            'address' => 'required|string',

        ]);
        return $this->apiUserRepository->updateByToken($params);
    }
}
