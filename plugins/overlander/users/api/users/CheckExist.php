<?php

namespace Overlander\Users\Api\Users;

use Legato\Api\Helpers\RestHelper;
use Illuminate\Http\Request;

class CheckExist extends AbstractUsers
{
    public function __invoke(Request $request): array
    {
        $params = $request->all();
        RestHelper::validate($params, [
            'email' => 'email|regex:/^[\w\.]+@([\w-]+\.)+[\w-]{2,4}$/',
            'phone' => 'numeric|regex:/^[0-9]+$/',
            'member_no' => 'numeric|regex:/^[0-9]{1,6}$/',
        ]);

        return $this->users->checkExist($params);
    }
}
