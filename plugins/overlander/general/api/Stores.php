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
    if (!empty($param['id'])) {
      return $this->stores->getById($param['id']);
    }
    return $this->stores->getAll();
  }
}
