<?php

namespace Overlander\General\Api;

use Illuminate\Http\Request;
use Overlander\General\Repository\Stores as RepositoryStores;

class Stores
{
  public RepositoryStores $stores;

  public function __construct(RepositoryStores $stores)
  {

    $this->stores = $stores;
  }
  public function getApi(Request $request)
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
