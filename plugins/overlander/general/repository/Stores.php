<?php

namespace Overlander\General\Repository;

use Exception;
use Overlander\General\Models\Stores as ModelsStores;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Stores
{
  public ModelsStores $stores;

  public function __construct(ModelsStores $stores)
  {
    $this->stores = $stores;
  }

  public function convertData($stores)
  {
    return [
      'name' => $stores->name,
      'image' => $stores->contents,
      'shop_id' => $stores->shop_id,
      'area' => $stores->area,
      'address' => $stores->address,
      'phone_number' => $stores->phone_number,
      'start_hour' => $stores->start_hour,
      'end_hour' => $stores->end_hour,
    ];
  }

  public function getAll()
  {
    try {
      $list = $this->stores->all();

      $data = [];

      foreach ($list as $key => $value) {
        $data[] = $this->convertData($value);
      }
      return $data;
    } catch (Exception $th) {
      throw new BadRequestHttpException('fail!!!');
    }
  }

  public function getById($id)
  {
    try {

      $data = $this->stores->getById($id);
      return $this->convertData($data);
    } catch (Exception $th) {

      throw new BadRequestHttpException('fail!!!');
    }
  }
}
