<?php

namespace Overlander\General\Api\Stores;

use Illuminate\Http\Request;

class GetAll extends AbstractStores
{
    public function __invoke(Request $request): array
  {
    $param = $request->all();
    $result = null;
    if (!empty($param['id'])) {
      $result = $this->stores->getById($param['id']);
      if (empty($result)) {
        return [
          'message' => 'empty'
        ];
      }
    } else {
      $result = $this->stores->getAll();
    }
    return $result;
  }
}
