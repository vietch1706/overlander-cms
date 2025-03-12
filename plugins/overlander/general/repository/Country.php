<?php

namespace Overlander\General\Repository;

use Lang;
use Legato\Api\Exceptions\NotFoundException;
use Overlander\General\Models\Countries;

class Country
{
    public Countries $countries;

    public function __construct(Countries $country)
    {
        $this->countries = $country;
    }

    public function getAll()
    {
        $list = $this->countries->all();
        $data = [];
        foreach ($list as $key => $value) {
            $data[] = $this->convertData($value);
        }
        if (empty($data)) {
            throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
        }
        return $data;
    }

    public function convertData($countries)
    {
        return [
            'country' => $countries->country,
            'code' => $countries->code,
            'image' => $countries->image,
        ];
    }

    public function getById($id)
    {
        $data = null;
        $country = $this->countries->getById($id)->first();
        if (!empty($country)) {
            $data = $this->convertData($country);
        } else {
            throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
        }
        return $data;
    }

}
