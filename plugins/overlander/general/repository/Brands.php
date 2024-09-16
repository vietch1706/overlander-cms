<?php

namespace Overlander\General\Repository;

use Exception;
use Overlander\General\Helper\General;
use Overlander\General\Models\Brands as ModelsBrands;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Brands
{
  public ModelsBrands $brand;
  public function __construct(ModelsBrands $brand)
  {
    $this->brand = $brand;
  }

  public function convertData($brand)
  {
    return [
      'name' => $brand->name,
      'image' =>  General::getBaseUrl() . $brand->image,
    ];
  }

  public function getAll()
  {
    try {
      $list = $this->brand->all();

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
      $brand = $this->brand->getById($id);
      if (!empty($brand)) {
        $data = $this->convertData($brand);
      }
      return $data;
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }
}
