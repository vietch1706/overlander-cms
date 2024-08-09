<?php

namespace Overlander\General\Api\Interests;

use Illuminate\Http\Request;

class GetInterest extends AbstractInterests
{
    public function __invoke(Request $request): array
    {
        $param = $request->all();
        if (!empty($param['id'])) {
            return $this->interests->getById($param['id']);
        }
        return $this->interests->getAll();
    }
}
