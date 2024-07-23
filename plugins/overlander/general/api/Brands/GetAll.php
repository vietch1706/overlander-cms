<?php

namespace Overlander\General\Api\Brands;

use Illuminate\Http\Request;

class GetAll extends AbstractBrands
{

    public function __invoke(Request $request): array
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
