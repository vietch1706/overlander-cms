<?php

namespace Overlander\Transaction\Api\PointHistory;

use Illuminate\Http\Request;
use Legato\Api\Helpers\RestHelper;

class GetByToken extends AbstractPointHistory
{
    public function __invoke()
    {
        return $this->pointHistory->getByToken();
    }
}
