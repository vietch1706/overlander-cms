<?php

namespace Overlander\General\Api;

use Overlander\General\Repository\Interests as RepositoryInterests;

class Interests
{
    public RepositoryInterests $interests;

    public function __construct(RepositoryInterests $interest)
    {

        $this->interests = $interest;
    }

    public function getInterests()
    {
        return $this->interests->getAll();
    }
}
