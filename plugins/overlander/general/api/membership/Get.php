<?php

namespace Overlander\General\Api\Membership;

use Illuminate\Http\Request;

class Get extends AbstractMembership
{
    public function __invoke(Request $request)
    {
        $param = $request->all();
        if (!empty($param['id'])) {
            return $this->membershipTier->getById($param['id']);
        }
        return $this->membershipTier->getAll();
    }
}
