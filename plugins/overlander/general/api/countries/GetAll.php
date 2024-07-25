<?php

namespace Overlander\General\Api\Countries;

use Illuminate\Http\Request;

class GetAll extends AbstractCountries
{

    public function __invoke(Request $request): array
    {
        $param = $request->all();
        $result = null;
        if (!empty($param['id'])) {
            $result = $this->countries->getById($param['id']);
        } else {
            return $this->countries->getAll();
        }
        if (empty($result)) {
            return [
                'message' => 'empty'
            ];
        }
        return $result;
    }
}
