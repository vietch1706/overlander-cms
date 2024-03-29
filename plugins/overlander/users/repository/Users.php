<?php

namespace Overlander\Users\Repository;

use Exception;
use Overlander\Users\Models\Users as ModelUsers;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class Users
{
  public ModelUsers $users;

  public function __construct(ModelUsers $user)
  {
    $this->users = $user;
  }

  public function convertData($users)
  {
    return [
      'first_name' => $users->first_name,
      'last_name' => $users->last_name,
      'phone' => $users->phone,
      'country' => $users->country,
      'email' => $users->email,
      'birthday' => $users->birthday,
      'gender' => $users->gender,
      'interest' => $users->interest,
      'points' => $users->points,
      'membership_tier_id' => $users->points,
      'address' => $users->address,
    ];
  }

  public function add($data)
  {
    try {
      if (empty($data['interest'])) {
        $data['interest'] = 'null';
      }
      ModelUsers::insert(
        [
          'first_name' => $data['first_name'],
          'last_name' => $data['last_name'],
          'phone' => $data['phone'],
          'password' => $data['password'],
          'country' => $data['country'],
          'email' => $data['email'],
          'birthday' => date('Y-m-d', strtotime($data['birthday'])),
          'gender' => $data['gender'],
          'interest' => $data['interest'],
          'address' => $data['address'],
          'is_existing' => 'true',
          'points' => '0',
          'membership_tier_id' => '1',
          'published_date' => date('Y-m-d'),
          'expired_date' => date('Y-m-d', strtotime("+ 3 months", strtotime(date('Y-m-d')))),
          'created_at' => date('Y-m-d'),
          'updated_at' => date('Y-m-d'),
        ],
      );

      return [
        'message' => 'Save successfull!',
      ];
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }
}
