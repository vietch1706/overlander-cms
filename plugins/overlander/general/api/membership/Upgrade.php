<?php

namespace Overlander\General\Api\Membership;
use Illuminate\Http\Request;
use Legato\Api\Helpers\RestHelper;

class Upgrade extends AbstractMembership
{
    public function __invoke(Request $request)
    {
        return $this->membershipTier->upgrade();
    }
}
