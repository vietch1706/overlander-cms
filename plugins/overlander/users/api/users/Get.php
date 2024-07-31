<?php

namespace Overlander\Users\Api\Users;

use Illuminate\Http\Request;
use Legato\Api\Helpers\RestHelper;

class Get extends AbstractUsers
{

    public function __invoke(Request $request)
    {
        $params = $request->all();
        RestHelper::validate($params, [
            'email' => 'email|regex:/^[\w\.]+@([\w-]+\.)+[\w-]{2,4}$/',
            'phone' => 'numeric|regex:/^[0-9]+$/',
            'member_no' => 'numeric|regex:/^[0-9]{1,6}$/',
        ]);
        if (!empty($params['email'])) {
            return $this->users->getByEmail($params['email']);
        } elseif (!empty($params['phone'])) {
            return $this->users->getByPhone($params['phone']);
        }
        return $this->users->getByMemberNumber($params['member_no']);
    }
}
