<?php

namespace Overlander\General\Repository;

use Exception;
use Overlander\General\Models\Countries;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Country
{
  public Countries $countries;

  public function __construct(Countries $country)
  {
    $this->countries = $country;
  }

  public function convertData($countries)
  {
    return [
      'iso' => $countries->iso,
      'name' => $countries->name,
      'iso3' => $countries->iso3,
      'phonecode' => $countries->phonecode,
    ];
  }

  public function getAll()
  {
    try {
      $list = $this->countries->all();

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
      $country = $this->countries->getById($id)->first();
      if (!empty($country)) {
        $data = $this->convertData($country);
      }
      return $data;
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }

  public function getByISO($iso)
  {
    try {
      $data = null;
      $country = $this->countries->getByISO($iso)->first();
      if (!empty($country)) {
        $data = $this->convertData($country);
      }
      return $data;
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }
}
