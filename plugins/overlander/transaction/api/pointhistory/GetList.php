<?php

namespace Overlander\Transaction\Api\PointHistory;

use Illuminate\Http\Request;
use Legato\Api\Helpers\RestHelper;
use Overlander\General\Helper\General;

class GetList extends AbstractPointHistory
{
    public function __invoke(Request $request)
    {
        $param = $request->all();

        $limit = $param['limit'] ?? General::LIMIT_DEFAULT;

        $page = $param['page'] ?? General::PAGE_DEFAULT;

        $type = $param['type'] ?? '';

        return $this->pointHistory->getList($limit, $page ,$type);
    }
}
