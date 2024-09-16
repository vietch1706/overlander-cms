<?php

namespace Overlander\General\Api;

use Illuminate\Http\Request;
use Overlander\General\Repository\Banners as RepositoryBanner;

class Banners
{
  public RepositoryBanner $banner;

  public function __construct(RepositoryBanner $banner)
  {
    $this->banner = $banner;
  }


  public function getApi(Request $request)
  {
    $param = $request->all();
    $result = null;
    if (!empty($param['id'])) {
      $result = $this->banner->getById($param['id']);
      if (empty($result)) {
        return [
          'message' => 'empty'
        ];
      }
    } else {
      $result = $this->banner->getAll();
    }
    return $result;
  }
}
