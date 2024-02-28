<?php

namespace Overlander\General\Api;

use Illuminate\Http\Request;
use Overlander\General\Repository\Brands as RepositoryBrands;

class Brands
{
  public RepositoryBrands $brand;

  public function __construct(RepositoryBrands $brand)
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
