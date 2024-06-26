<?php

namespace Overlander\General\Repository;

use Exception;
use Overlander\General\Models\Interests as ModelInterests;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Interests
{
    public ModelInterests $interests;

    public function __construct(ModelInterests $interest)
    {
        $this->interests = $interest;
    }

    public function getAll()
    {
        try {
            $list = $this->interests->all();

            $data = [];

            foreach ($list as $key => $value) {
                $data[] = $this->convertData($value);
            }
            return $data;
        } catch (Exception $th) {
            throw new BadRequestHttpException($th->getMessage());
        }
    }

    public function convertData($data)
    {
        return [
            'name' => $data->name,
        ];
    }
}
