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
    if (!empty($param['slug'])) {
      return $this->spPage->getBySlug($param['slug']);
    } elseif (!empty($param['id'])) {
      return $this->spPage->getById($param['id']);
    }

    return $this->spPage->getAll();
  }
}
