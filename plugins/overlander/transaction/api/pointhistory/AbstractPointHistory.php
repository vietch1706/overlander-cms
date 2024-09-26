<?php

namespace Overlander\Transaction\Api\PointHistory;

use Overlander\Transaction\Repository\PointHistory as RepositoryPointHistory;
class AbstractPointHistory
{
    public RepositoryPointHistory $pointHistory;
    public function __construct(RepositoryPointHistory $pointHistory) {
        $this->pointHistory = $pointHistory;
    }
}
