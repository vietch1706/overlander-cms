<?php

namespace Overlander\Users\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Overlander\Users\Repository\ExistUsers as RepositoryExistUsers;
use Overlander\Users\Repository\Users as RepositoryUsers;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class ExistUsers
{

    public RepositoryExistUsers $existUsers;
    public RepositoryUsers $users;

    public function __construct(RepositoryExistUsers $existUser, RepositoryUsers $user)
    {
        $this->existUsers = $existUser;
        $this->users = $user;
    }

    public function step1(Request $request)
    {
        $param = $request->all();
        $rules = [
            'method' => 'required',
            'answer' => 'required',
        ];
        $validator = Validator::make($param, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
        }
        return $this->existUsers->step1($param);
    }

    public function step1VerifyCode(Request $request)
    {
        $param = $request->all();
        return $this->users->verifyCode($param['email'], $param['code']);
    }

    public function getQuestions(Request $request)
    {
        $param = $request->all();
        $result = null;
        $rules = [
            'previous' => 'required|integer',
        ];
        $validator = Validator::make($param, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
        }
        $result = $this->existUsers->getQuestions($param['previous']);
        if (empty($result)) {
            return [
                'message' => 'empty'
            ];
        }
        return $result;
    }

    public function step2(Request $request)
    {
        $param = $request->all();
        $rules = [
            'question1' => 'required',
            'answer1' => 'required',
            'question2' => 'required',
            'answer2' => 'required',
        ];
        $validator = Validator::make($param, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
        }
        return $this->existUsers->step2($param);
    }
}
