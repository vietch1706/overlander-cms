<?php

namespace Overlander\General\Api\Interests;

use Overlander\General\Repository\Interests as RepositoryInterests;

class AbstractInterests
{

    public RepositoryInterests $interests;

    public function __construct(RepositoryInterests $interest)
    {

        $this->interests = $interest;
    }

}
