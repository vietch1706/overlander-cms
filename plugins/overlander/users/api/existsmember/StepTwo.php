<?php

namespace Overlander\Users\Api\ExistsMember;

use Illuminate\Http\Request;
use Legato\Api\Helpers\RestHelper;

class StepTwo extends AbstractExistUser
{
    public function __invoke(Request $request)
    {
        $params = $request->all();
        RestHelper::validate($params, [
            'question1' => 'required',
            'answer1' => 'required',
            'question2' => 'required',
            'answer2' => 'required',
        ]);
        return $this->existUsers->step2($params);
    }

}
