<?php

namespace Overlander\General\Api\Countries;

use Illuminate\Http\Request;

class GetCountry extends AbstractCountries
{

    public function __invoke(Request $request): array
    {
        $param = $request->all();
        if (!empty($param['id'])) {
            return $this->countries->getById($param['id']);
        }
        return $this->countries->getAll();
    }
}
