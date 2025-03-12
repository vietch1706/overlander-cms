<?php

namespace Overlander\General\Repository;

use Lang;
use Legato\Api\Exceptions\NotFoundException;
use Overlander\General\Models\Interests as ModelInterests;

class Interests
{
    public ModelInterests $interests;

    public function __construct(ModelInterests $interest)
    {
        $this->interests = $interest;
    }

    public function getAll()
    {
        $list = $this->interests->all();
        $data = [];
        foreach ($list as $key => $value) {
            $data[] = $this->convertData($value);
        }
        if (empty($data)) {
            throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
        }
        return $data;
    }

    public function convertData($data)
    {
        return [
            'id' => $data->id,
            'name' => $data->name,
        ];
    }

    public function getById($id)
    {
        $data = null;
        $interest = $this->interests->getById($id)->first();
        if (!empty($interest)) {
            $data = $this->convertData($interest);
        } else {
            throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
        }
        return $data;
    }
}
