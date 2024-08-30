<?php

namespace Overlander\Users\Api\ExistsMember;

use Illuminate\Http\Request;
use Legato\Api\Helpers\RestHelper;

class GetQuestions extends AbstractExistUser
{
    public function __invoke(Request $request)
    {
        $params = $request->all();
        RestHelper::validate($params, [
            'previous' => 'required|numeric|between:0,6',
        ]);
        return $this->existUsers->getQuestions($params['previous']);
    }
}
