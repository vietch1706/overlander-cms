<?php

namespace Overlander\General\Api;

use Illuminate\Http\Request;
use Overlander\General\Repository\Interests as RepositoryInterests;

class Interests
{
    public RepositoryInterests $interests;

    public function __construct(RepositoryInterests $interest)
    {

        $this->interests = $interest;
    }

    public function getInterests(Request $request)
    {
        $param = $request->all();
        $result = null;
        if (!empty($param['id'])) {
            $result = $this->interests->getById($param['id']);
        } else {
            return $this->interests->getAll();
        }
        if (empty($result)) {
            return [
                'message' => 'empty'
            ];
        }
        return $result;
    }
}
