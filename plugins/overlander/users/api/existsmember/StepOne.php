<?php

namespace Overlander\Users\Api\ExistsMember;

use Illuminate\Http\Request;
use Legato\Api\Helpers\RestHelper;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class stepOne extends AbstractExistUser
{
    public function __invoke(Request $request)
    {
        $params = $request->all();
        RestHelper::validate($params, [
            'question1' => 'required',
            'answer1' => 'required',
        ]);
        return $this->existUsers->step1($params);
    }
}
