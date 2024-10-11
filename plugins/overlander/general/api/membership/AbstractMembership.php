<?php

namespace Overlander\General\Api\Membership;

use Overlander\General\Repository\MembershipTier as RepositoryMembershipTier;

class AbstractMembership
{
    public RepositoryMembershipTier $membershipTier;

    public function __construct(RepositoryMembershipTier $membershipTier)
    {
        $this->membershipTier = $membershipTier;
    }
}
