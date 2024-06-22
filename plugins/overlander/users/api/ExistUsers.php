<?php

namespace Overlander\Users\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Overlander\Users\Repository\ExistUsers as RepositoryExistUsers;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class ExistUsers
{

    public RepositoryExistUsers $existUsers;

    public function __construct(RepositoryExistUsers $existUser)
    {
        $this->existUsers = $existUser;
    }

    public function setp1SendCode(Request $request)
    {
        $param = $request->all();
        $rules = [
            'email' => ['email', 'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'],
        ];
        $validator = Validator::make($param, $rules,);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
        }
        return $this->existUsers->step1Code($param);
    }

    public function step1VerifyCode(Request $request)
    {
        $param = $request->all();
        return $this->existUsers->validationStep1($param);
    }

    public function step2Questions(Request $request)
    {
        $param = $request->all();
        $rules = [
            'question' => 'required|exists:overlander_general_verification_questions,name',
            'answer' => 'required',
        ];
        $validator = Validator::make($param, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
        }
        return $this->existUsers->step2Questions($param);
    }
}
