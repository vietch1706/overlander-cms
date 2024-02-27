<?php

namespace Overlander\General\Api;

use Illuminate\Http\Request;
use Overlander\General\Models\Brands as ModelsBrands;

class Brands
{
  public ModelsBrands $brand;

  public function __construct(ModelsBrands $brand)
  {
    $this->brand = $brand;
  }


  public function getApi(Request $request)
  {
    $param = $request->all();
    if (!empty($param['id'])) {
      return $this->brand->getById($param['id']);
    }
    return $this->brand->getAll();
  }
}
