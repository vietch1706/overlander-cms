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


  public function getAllBrands(Request $request)
  {
    $param = $request->all();
    $result = null;
    if (!empty($param['id'])) {
      $result = $this->brand->getById($param['id']);
      if (empty($result)) {
        return [
          'message' => 'empty'
        ];
      }
    } else {
      $result = $this->brand->getAll();
    }
    return $result;
  }
}
