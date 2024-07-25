<?php

namespace Overlander\General\Api\Interests;

use Illuminate\Http\Request;

class GetAll extends AbstractInterests
{
    public function __invoke(Request $request): array
    {
        $param = $request->all();
        $result = null;
        if (!empty($param['id'])) {
            $result = $this->interests->getById($param['id']);
        } else {
            return $this->interests->getAll();
        }
        if (empty($result)) {
            return [
                'message' => 'empty'
            ];
        }
        return $result;
    }
}
