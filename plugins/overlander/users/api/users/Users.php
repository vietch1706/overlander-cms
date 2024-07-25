<?php

namespace Overlander\Users\Api\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Users
{


    public function login(Request $request)
    {
        $param = $request->all();
        $rules = [
            'password' => 'required',
            'email' => 'email'
        ];
        $validator = Validator::make($param, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
        }
        return $this->users->login($param);
    }

    public function resetPassword(Request $request)
    {
        $param = $request->all();
        $rules = [
            'new_password' => 'required',
            'confirm_password' => 'required',
            'email' => 'required|email'
        ];
        $validator = Validator::make($param, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
        }
        return $this->users->resetPassword($param['new_password'], $param['confirm_password'], $param['email']);

    }

    public function checkExistUser(Request $request)
    {
        $param = $request->all();
        $rules = [
            'phone' => 'integer',
            'email' => ['email', 'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'],
        ];
        $validator = Validator::make($param, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
        }
        return $this->users->checkExist($param);
    }

    public function sendCode(Request $request)
    {
        $param = $request->all();
        $rules = [
            'email' => 'required|email',
            'method' => 'required',
        ];
        $validator = Validator::make($param, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
        }
        return $this->users->sendCode($param['email'], $param['method']);
    }

    public function verifyCode(Request $request)
    {
        $param = $request->all();
        $rules = [
            'email' => 'required|email',
            'code' => 'required',
        ];
        $validator = Validator::make($param, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
        }
        return $this->users->verifyCode($param['email'], $param['code']);
    }
}
