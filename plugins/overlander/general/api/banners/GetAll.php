<?php

namespace Overlander\General\Api\Banners;

use Illuminate\Http\Request;

class GetAll extends AbstractBanners
{

  public function __invoke(Request $request): array
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
