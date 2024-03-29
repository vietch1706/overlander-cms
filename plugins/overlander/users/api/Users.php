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
  public function getApi(Request $request)
  {
    $param = $request->all();
    $rules = [
      'first_name' => 'required',
      'last_name' => 'required',
      'phone' => 'required|unique:overlander_users_users,phone|regex:/(84|0[3|5|7|8|9])+([0-9]{8})/|min_digits:10',
      'password' => 'required',
      'country' => 'required',
      'email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/|unique:overlander_users_users,email',
      'birthday' => 'required',
      'gender' => 'required',
      'address' => 'required',
    ];

    $validator = Validator::make($param, $rules);
    if ($validator->fails()) {
      throw new BadRequestHttpException($validator->messages()->first());
    } else {
      return $this->users->add($param);
    }
    // $result = null;
    // if (!empty($param['id'])) {
    //   $result = $this->users->getById($param['id']);
    //   if (empty($result)) {
    //     return [
    //       'message' => 'empty'
    //     ];
    //   }
    // } else {
    //   $result = $this->users->getAll();
    // }
    // return $result;
  }
}
