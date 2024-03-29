<?php

namespace Overlander\General\Repository;

use Exception;
use Overlander\General\Helper\General;
use Overlander\General\Models\Banner as ModelsBanners;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Banners
{
  public ModelsBanners $banner;
  public function __construct(ModelsBanners $banner)
  {
    $this->banner = $banner;
  }

  public function convertData($banner)
  {
    return [
      'name' => $banner->name,
      'image' =>  General::getBaseUrl() . $banner->image,
      'link' => $banner->link,
    ];
  }

  public function getAll()
  {
    try {
      $list = $this->banner->all();

      $data = [];

      foreach ($list as $key => $value) {
        $data[] = $this->convertData($value);
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
      $banner = $this->banner->getById($id);
      if (!empty($banner)) {
        $data = $this->convertData($banner);
      }
      return $data;
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }
}
