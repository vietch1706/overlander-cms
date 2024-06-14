<?php

namespace Overlander\Users\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Overlander\Users\Repository\ExistUsers;
use Overlander\Users\Repository\Users as RepositoryUsers;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Users
{
  public RepositoryUsers $users;
  public ExistUsers $verify;

  public function __construct(RepositoryUsers $user, ExistUsers $verify)
  {
    $this->users = $user;
    $this->verify = $verify;
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
      'month' => 'required',
      'year' => 'required',
      'gender' => 'required',
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
    } else {
      return $this->users->create($param);
    }
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
    } else {
      return $this->users->checkPassword($param);
    }
  }

  public function sendCode(Request $request)
  {
    $param = $request->all();
    return $this->verify->step1Code($param);
  }

  public function verifyCode(Request $request)
  {
    $param = $request->all();
    return $this->verify->validationStep1($param);
  }
}
