<?php

namespace Overlander\General\Repository;

use Exception;
use Lang;
use Legato\Api\Exceptions\NotFoundException;
use Overlander\General\Helper\General;
use Overlander\General\Models\Banner as ModelsBanners;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Banners
{
    public ModelsBanners $banners;

    public function __construct(ModelsBanners $banner)
    {
        $this->banners = $banner;
    }

    public function getAll()
    {
        $list = $this->banners->all();
        $data = [];
        foreach ($list as $key => $value) {
            $data[] = $this->convertData($value);
        }
        if (empty($data)) {
            throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
        }
        return $data;
    }

    public function convertData($banner)
    {
        return [
            'name' => $banner->name,
            'image' => General::getBaseUrl() . $banner->image,
            'link' => $banner->link,
        ];
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
