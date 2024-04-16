<?php

namespace Overlander\Users\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Overlander\Users\Repository\Users as RepositoryUsers;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use function PHPUnit\Framework\isEmpty;

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

    $update = function ($param, $rules, $customMessages) {
      $validator = Validator::make($param, $rules, $customMessages);
      if ($validator->fails()) {
        throw new BadRequestHttpException($validator->messages()->first());
      } else {
        return $this->users->update($param);
      }
    };

    $rules = [
      'member_no' => 'required',
      'first_name' => 'required',
      'last_name' => 'required',
      'phone' => ['required', 'unique:overlander_users_users,phone', 'regex:/(\+84|0[3|5|7|8|9])+([0-9]{8})/'],
      'password' => 'required',
      'country' => 'required',
      'email' => ['required', 'email', 'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', 'unique:overlander_users_users,email'],
      'birthday' => 'required',
      'gender' => 'required',
    ];

    $customMessages = [
      'member_no.required' => 'The member number is required.',
      'phone.regex' => 'The phone number is already existed.',
      'email.regex' => 'The email address is already existed.',
    ];
    $result = $this->users->getByMemberNumber($param['member_no']);
    if (!empty($result)) {
      if ($result['member_no'] == $param['member_no']) {
        unset($rules['member_no'], $rules['email'], $rules['phone']);
        return $update($param, $rules, $customMessages);
      }
    }
    $result = $this->users->getByEmail($param['email']);
    if (!empty($result)) {
      unset($rules['member_no'], $rules['email'], $rules['phone']);
      return $update($param, $rules, $customMessages);
    }
    $result = $this->users->getByPhone($param['phone']);
    if (!empty($result)) {
      unset($rules['member_no'], $rules['email'], $rules['phone']);
      return $update($param, $rules, $customMessages);
    } else {
      $validator = Validator::make($param, $rules, $customMessages);
      if ($validator->fails()) {
        throw new BadRequestHttpException($validator->messages()->first());
      } else {
        return $this->users->create($param);
      }
    }
  }
}
