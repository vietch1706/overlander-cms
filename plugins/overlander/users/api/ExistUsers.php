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

  public function codeStep1(Request $request)
  {
    $param = $request->all();
    $verifyMethod = array_key_first($param);
    if (!empty($param['phone']) && substr($param['phone'], 0, 1) === '0') {
      $param['phone'] = preg_replace('/^0/', '+84', $param['phone']);
    }
    $rules = [
      'phone' => ['exists:overlander_users_users'],
      'email' => ['email', 'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', 'exists:overlander_users_users'],
      'member_no' => ['exists:overlander_users_users'],
    ];

    $customeMessages = [
      'email' => 'The mail you enter is not exist!',
      'phone' => 'The phone you enter is not exist!',
      'member_no' => 'The member number you enter is not eixst!',
    ];
    $validator = Validator::make($param, $rules, $customeMessages);
    if ($validator->fails()) {
      throw new BadRequestHttpException($validator->messages()->first());
    }
    if ($verifyMethod === 'email') {
      return $this->existUsers->step1Code($param);
    } elseif ($verifyMethod === 'phone') {
      return [
        'message' => 'Test verify with phone!',
      ];
    }
    return [
      'message' => 'Test verify with member number!',
    ];
  }

  public function validationStep1(Request $request)
  {
    $param = $request->all();
    return $this->existUsers->validationStep1($param);
  }
}
