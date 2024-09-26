<?php

namespace Overlander\General\Repository;

use Overlander\General\Helper\General;
use Overlander\General\Models\MembershipTier as MembershipTierModel;

class MembershipTier
{

    public MembershipTierModel $membershipTiers;

    public function __contruct(MembershipTierModel $membershipTier)
    {
        $this->membershipTiers = $membershipTier;
    }

    public static function convertData($membership)
    {
        return [
            'id' => $membership->id,
            'name' => $membership->name,
            'logo' => General::getBaseUrl() . $membership->logo,
        ];
    }
}
