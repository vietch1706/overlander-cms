<?php

namespace Overlander\General\Api;

use Illuminate\Http\Request;
use Overlander\General\Repository\SupportivePages as RepositorySupportivePages;

class SupportivePages
{
  public RepositorySupportivePages $spPage;

  public function __construct(RepositorySupportivePages $spPage)
  {

    $this->spPage = $spPage;
  }
  public function getApi(Request $request)
  {
    $param = $request->all();
    $result = null;
    if (!empty($param['slug'])) {
      $result =  $this->spPage->getBySlug($param['slug']);
    } elseif (!empty($param['id'])) {
      $result = $this->spPage->getById($param['id']);
    } else {
      return $this->spPage->getAll();
    }
    if (empty($result)) {
      return [
        'message' => 'empty'
      ];
    }
    return $result;
  }
}
