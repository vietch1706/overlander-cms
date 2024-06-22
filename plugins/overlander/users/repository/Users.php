<?php

namespace Overlander\Users\Repository;

use Carbon\Carbon;
use Exception;
use Overlander\General\Helper\General;
use Overlander\General\Models\Countries;
use Overlander\Users\Models\Users as ModelUsers;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class Users
{
    public ModelUsers $users;
    public Countries $countries;

    public function __construct(ModelUsers $user, Countries $country)
    {
        $this->users = $user;
        $this->countries = $country;
    }


    public function create($data)
    {
        if (empty($data['interests'])) {
            $data['interests'] = ' ';
        }
        if (empty($data['month'])) {
            $data['month'] = 0;
        }
        if (empty($data['year'])) {
            $data['year'] = 0;
        }
        if (empty($data['gender'])) {
            $data['gender'] = null;
        }
        $lastestUser = $this->users->orderBy('member_no', 'desc')->first();
        if (!empty($lastestUser)) {
            $member_no = $lastestUser['member_no'] + 1;
        } else {
            $member_no = 100000;
        }
        $user = [
            'member_no' => $member_no,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'country_id' => $this->countries->where('name', $data['country'])->first()['id'],
            'email' => $data['email'],
            'month' => $data['month'],
            'year' => $data['year'],
            'gender' => $data['gender'],
            'interest_id' => $data['interests'],
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
            return $th->getMessage();
        }
    }

    public function resetPassword($param)
    {
        $phone = str_replace(' ', '+', $param['phone']);
        if ($param['new_password'] == $param['confirm_password']) {
            $user = [
                'password' => $param['new_password'],
            ];
            $this->users->where('phone', $phone)->update($user);
            return [
                'message' => 'Change password successfull!',
            ];
        }
        return [
            'message' => 'Password do not match!',
        ];
    }

    public function update($data)
    {
        // $users = new ModelUsers();
        if (empty($data['interests'])) {
            $data['interests'] = ' ';
        }
        $user = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'country_id' => $this->countries->where('name', $data['country'])->first()['id'],
            'email' => $data['email'],
            'month' => $data['month'],
            'year' => $data['year'],
            'gender' => $data['gender'],
            'interest_id' => $data['interests'],
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

    public function sendCode($data)
    {
        $data = str_replace(' ', '+', $data);
        $user = $this->users->where('phone', $data)->first();
        if (Carbon::now()->diffInMinutes($user['send_mail_at']) < 10 && !empty($user['verification_code'])) {
            return [
                'message' => 'You Can Only Send Verification Code Once Each Ten Minutes!'
            ];
        }
        if ($user['send_time'] == 3) {
            return [
                'message' => 'You Can Send Code 3 times a day',
            ];
        }
        $code = General::generateRandomCode();
        $updateDatas = [
            'verification_code' => $code,
            'send_mail_at' => Carbon::now()->toDateTimeString(),
            'send_time' => $user['send_time'] + 1,
        ];

        $this->users->where('phone', $user['phone'])->update($updateDatas);
        return [
            'message' => 'Verify Code Have Been Sent to your phone number!'
        ];
    }

    public function verifyCode($data)
    {
        $phone = str_replace(' ', '+', $data['phone']);
        $user = $this->users->where('phone', $phone)->first();
        if ($user['is_active']) {
            $updateDatas = [
                'verification_code' => null,
                'send_mail_at' => null,
                'send_time' => 0,
            ];
        } else {
            $updateDatas = [
                'verification_code' => null,
                'send_mail_at' => null,
                'is_active' => 1,
                'active_date' => Carbon::now()->toDateTimeString(),
                'send_time' => 0,
            ];
        }
        if (Carbon::now()->diffInMinutes($user['send_mail_at']) > 10 && $data['code'] == $user['verification_code']) {
            $this->users->where('phone', $user['phone'])->update($updateDatas);
            return [
                'message' => 'Verification code expired!'
            ];
        }
        if ($data['code'] == $user['verification_code']) {
            $this->users->where('phone', $user['phone'])->update($updateDatas);
            return [
                'message' => 'Verify successfully!',
            ];
        }
        return [
            'message' => 'Wrong Code. Try Again!',
        ];
    }

    public function getByPhone($phone)
    {
        try {
            $data = null;
            $phone = str_replace(' ', '+', $phone);
            $user = $this->users->getByPhone($phone)->first();
            if (!empty($user)) {
                $data = $this->convertData($user);
            } else {
                $data = '';
            }
            return $data;
        } catch (Exception $th) {
            throw new BadRequestHttpException($th->getMessage());
        }
    }

    public function convertData($users)
    {
        return [
            'member_no' => $users->member_no,
            'first_name' => $users->first_name,
            'last_name' => $users->last_name,
            'phone' => $users->phone,
            'password' => $users->password,
            'country' => $users->country_id,
            'email' => $users->email,
            'month' => $users->month,
            'year' => $users->year,
            'gender' => $users->gender,
            'interests' => $users->interest_id,
            'points' => $users->points,
            'membership_tier_id' => $users->points,
            'address' => $users->address,
            'is_existing_member' => $users->is_existing_member,
            'is_active' => $users->is_active,
            'active_date' => $users->active_date,
            'send_mail_at' => $users->send_mail_at,
        ];
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

    public function checkPassword($param)
    {
        $result = false;
        if (!empty($param['member_no'])) {
            $member_no = preg_replace('/[^0-9]/', '', $param['member_no']);
            $member_prefix = preg_replace('/[^a-zA-Z]/', '', $param['member_no']);
            $data = $this->users->where('member_no', $member_no)->first();
            if ($data['member_prefix'] == $member_prefix) {
                $result = true;
            }
        } elseif (!empty($param['phone'])) {
            $data = $this->users->where('phone', $param['phone'])->first();
            $result = true;
        }
        if (!$result) {
            return [
                'message' => 'User Not Exist',
            ];
        } else {
            if ($param['password'] == $data['password']) {
                return [
                    'message' => 'Login Successfull',
                ];
            }
            return [
                'message' => 'Wrong Password',
            ];
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
}
