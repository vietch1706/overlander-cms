<?php

namespace Overlander\General\Repository;

use Exception;
use Overlander\General\Models\Supportivepages as ModelsSupportivepages;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SupportivePages
{
  public ModelsSupportivepages $spPage;

  public function __construct(ModelsSupportivepages $spPage)
  {
    $this->spPage = $spPage;
  }

  public function convertData($spPage)
  {
    return [
      'title' => $spPage->title,
      'contents' => $spPage->contents,
      'slug' => $spPage->slug,
    ];
  }

  public function getAll()
  {
    try {
      $list = $this->spPage->all();

      $data = [];

      foreach ($list as $key => $value) {
        $data[] = $this->convertData($value);
      }
      return $data;
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }

  public function getBySlug($slug)
  {
    try {
      $data = null;
      $spPage = $this->spPage->getBySlug($slug)->first();
      if (!empty($spPage)) {
        $data = $this->convertData($spPage);
      }
      return $data;
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }

  public function getById($id)
  {
    try {
      $data = null;
      $spPage = $this->spPage->getById($id)->first();
      if (!empty($spPage)) {
        $data = $this->convertData($spPage);
      }
      return $data;
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }
}
