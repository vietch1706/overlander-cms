<?php

namespace Overlander\Users\Api\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Overlander\Users\Repository\Users as RepositoryUsers;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Users
{


    public function update(Request $request)
    {
        $param = $request->all();

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => ['unique:overlander_users_users,phone'],
            'password' => 'required',
            'country' => 'required',
            'email' => ['email', 'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', 'unique:overlander_users_users,email'],
        ];

        $customMessages = [
            'phone.regex' => 'The phone number is already existed.',
            'email.regex' => 'The email address is already existed.',
        ];

        $validator = Validator::make($param, $rules, $customMessages);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
            // return [
            //   'code' => '400',
            //   'message' => $validator->messages()->first(),
            // ];
        }
        return $this->users->create($param);

    }

    public function getUser(Request $request)
    {
        return $this->users->getUser();
    }

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
