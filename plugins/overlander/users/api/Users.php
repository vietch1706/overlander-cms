<?php

namespace Overlander\Users\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Overlander\Users\Repository\Users as RepositoryUsers;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Users
{
    public RepositoryUsers $users;

    public function __construct(RepositoryUsers $user)
    {
        $this->users = $user;
    }

    public function register(Request $request)
    {
        $param = $request->all();

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => ['required', 'unique:overlander_users_users,phone'],
            'password' => 'required',
            'country' => 'required',
            'email' => ['required', 'email', 'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', 'unique:overlander_users_users,email'],
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
        $param = $request->all();
        if (!empty($param['email'])) {
            return $this->users->getByEmail($param['email']);
        } elseif (!empty($param['phone'])) {
            $phone = str_replace(' ', '+', $param['phone']);
            return $this->users->getByPhone($phone);
        } elseif (!empty($param['member_no'])) {
            return $this->users->getByMemberNumber($param['member_no']);
        }
        return [
            'message' => 'User not found!'
        ];
    }

    public function login(Request $request)
    {
        $param = $request->all();
        $rules = [
            'password' => 'required',
        ];
        $validator = Validator::make($param, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
        }
        return $this->users->checkPassword($param);

    }

    public function resetPassword(Request $request)
    {
        $param = $request->all();
        $rules = [
            'new_password' => 'required',
            'confirm_password' => 'required',
            'phone' => 'required'
        ];
        $validator = Validator::make($param, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
        }
        return $this->users->resetPassword($param);

    }

    public function checkExistUser(Request $request)
    {
        $param = $request->all();
        $data = null;
        $messages = null;
        $rules = [
            'email' => ['email', 'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'],
        ];
        $validator = Validator::make($param, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
        }
        if (!empty($param['email'])) {
            $data = $this->users->getByEmail($param['email']);
            if (!empty($data)) {
                $messages = [
                    'email' => 'The email address already existed.',
                ];
            }
        }
        if (!empty($param['phone']) && $data != null) {
            if ($this->users->getByPhone($param['phone']) != null) {
                $messages = [
                    'email' => 'The email address already existed.',
                    'phone' => 'The phone number already existed.',
                ];
            }
        }
        if (!empty($param['phone']) && $data == null) {
            $data = $this->users->getByPhone($param['phone']);
            if (!empty($data)) {
                $messages = [
                    'phone' => 'The phone number already existed.',
                ];
            }
        }
        return $messages;
    }

    public function sendCode(Request $request)
    {
        $param = $request->all();
        return $this->users->sendCode($param['phone']);
    }

    public function verifyCode(Request $request)
    {
        $param = $request->all();
        return $this->users->verifyCode($param);
    }
}
