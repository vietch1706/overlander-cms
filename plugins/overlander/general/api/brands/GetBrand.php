<?php

namespace Overlander\General\Api\Brands;

use Illuminate\Http\Request;

class GetBrand extends AbstractBrands
{

    public function __invoke(Request $request): array
    {
        $param = $request->all();
        if (!empty($param['id'])) {
            return $this->brand->getById($param['id']);
        } elseif (!empty($param['name'])) {
            return $this->brand->getByName($param['name']);
        } elseif (!empty($param['code'])) {
            return $this->brand->getByCode($param['code']);
        }
        return $this->brand->getAll();
    }
}
