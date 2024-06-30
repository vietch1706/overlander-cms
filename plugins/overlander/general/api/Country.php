<?php

namespace Overlander\General\Api;

use Illuminate\Http\Request;
use Overlander\General\Repository\Country as RepositoryCountry;

class Country
{
    public RepositoryCountry $countries;

    public function __construct(RepositoryCountry $country)
    {

        $this->countries = $country;
    }

    public function getCountry(Request $request)
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
