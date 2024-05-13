<?php

namespace Overlander\Users\Repository;

use Carbon\Carbon;
use Exception;
use Overlander\General\Helper\General;
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
      'member_no' => $users->member_no,
      'first_name' => $users->first_name,
      'last_name' => $users->last_name,
      'phone' => $users->phone,
      'password' => $users->password,
      'country' => $users->country,
      'email' => $users->email,
      'birthday' => $users->birthday,
      'gender' => $users->gender,
      'interest' => $users->interest,
      'points' => $users->points,
      'membership_tier_id' => $users->points,
      'address' => $users->address,
      'is_existing_member' => $users->is_existing_member,
      'is_active' => $users->is_active,
      'active_date' => $users->active_date,
      'send_mail_at' => $users->send_mail_at,
    ];
  }

  public function create($data)
  {
    // $users = new ModelUsers();
    if (empty($data['interest'])) {
      $data['interest'] = ' ';
    }
    $user = [
      'member_no' => $data['member_no'],
      'member_prefix' => $data['member_prefix'],
      'first_name' => $data['first_name'],
      'last_name' => $data['last_name'],
      'phone' => $data['phone'],
      'password' => $data['password'],
      'country' => $data['country'],
      'email' => $data['email'],
      'birthday' => Carbon::parse($data['birthday'])->format('Y-m-d'),
      'gender' => $data['gender'],
      'interest' => $data['interest'],
      'address' => $data['address'],
      'published_date' => General::getCurrentDay(),
      'expired_date' => Carbon::now()->addMonth('3')->format('Y-m-d'),
      'created_at' => General::getCurrentDay(),
      'updated_at' => General::getCurrentDay(),
    ];
    try {
      $this->users->fill($user);
      $this->users->save();
      return [
        'message' => 'Save successfull!',
      ];
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }

  public function update($data)
  {
    // $users = new ModelUsers();
    if (empty($data['interest'])) {
      $data['interest'] = ' ';
    }
    $user = [
      'first_name' => $data['first_name'],
      'last_name' => $data['last_name'],
      'phone' => $data['phone'],
      'password' => $data['password'],
      'country' => $data['country'],
      'email' => $data['email'],
      'birthday' => Carbon::parse($data['birthday'])->format('Y-m-d'),
      'gender' => $data['gender'],
      'interest' => $data['interest'],
      'address' => $data['address'],
      'published_date' => General::getCurrentDay(),
      'expired_date' => Carbon::now()->addMonth('3')->format('Y-m-d'),
      'updated_at' => General::getCurrentDay(),
    ];
    try {
      $this->users->where('member_no', $data['member_no'])->update($user);
      return [
        'message' => 'Update Successfully!!!',
      ];
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }

  public function getByMemberNumber($memberNumber)
  {
    try {
      $data = null;
      $user = $this->users->getByMemberNumber($memberNumber)->first();
      if (!empty($user)) {
        $data = $this->convertData($user);
      }
      return $data;
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }
  public function getById($id)
  {
    try {
      $data = null;
      $user = $this->users->getById($id)->first();
      if (!empty($user)) {
        $data = $this->convertData($user);
      }
      return $data;
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }

  public function getByEmail($email)
  {
    try {
      $data = null;
      $user = $this->users->getByEmail($email)->first();
      if (!empty($user)) {
        $data = $this->convertData($user);
      }
      return $data;
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }

  public function getByPhone($phone)
  {
    try {
      $data = null;
      $user = $this->users->getByPhone($phone)->first();
      if (!empty($user)) {
        $data = $this->convertData($user);
      }
      return $data;
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }
}
