<?php

namespace Overlander\General\Repository;

use Lang;
use Legato\Api\Exceptions\NotFoundException;
use Overlander\General\Helper\General;
use Overlander\General\Models\Brands as ModelsBrands;
use Exception;

class Brands
{
    public ModelsBrands $brands;

    public function __construct(ModelsBrands $brand)
    {
        $this->brands = $brand;
    }

    public function getAll()
    {
        try {
            $list = $this->brands->all();
            $data = [];
            foreach ($list as $key => $value) {
                $data[] = $this->convertData($value);
            }
            if (empty($data)) {
                throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
            }
            return $data;
        } catch (Exception $th) {
            throw new NotFoundException($th->getMessage());
        }
    }

    public function convertData($brand)
    {
        return [
            'name' => $brand->name,
            'description' => $brand->description,
            'code' => $brand->code,
            'group' => $brand->group,
            'image' => General::getBaseUrl() . $brand->image,
        ];
    }

    public function getById($id)
    {
        try {
            $data = null;
            $brand = $this->brands->getById($id)->first();
            if (!empty($brand)) {
                $data = $this->convertData($brand);
            } else {
                throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
            }
            return $data;
        } catch (Exception $th) {
            throw new NotFoundException($th->getMessage());
        }
    }

//    public function getByName($name)
//    {
//        $data = null;
//        $brand = $this->brands->getByName($name)->first();
//        if (empty($brand)) {
//            throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
//        }
//        $data = $this->convertData($brand);
//        return $data;
//    }
    public function getByName($name)
    {
        try {
            $data = null;
            $brand = $this->brands->getByName($name)->first();
            if (empty($brand)) {
                throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
            }
            $data = $this->convertData($brand);
            return $data;
        } catch (Exception $th) {
            throw new NotFoundException($th->getMessage());
        }

    }

    public function getByCode($code)
    {
        try {
            $data = null;
            $brand = $this->brands->getByCode($code)->first();
            if (!empty($brand)) {
                $data = $this->convertData($brand);
            } else {
                throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
            }
            return $data;
        } catch (Exception $th) {
            throw new NotFoundException($th->getMessage());
        }
    }
}
