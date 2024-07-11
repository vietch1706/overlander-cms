<?php

namespace Overlander\Users\Repository;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;
use Lang;
use Overlander\General\Helper\General;
use Overlander\General\Models\Countries;
use Overlander\General\Models\Interests;
use Overlander\Logs\Models\Maillogs;
use Overlander\Users\Models\Users as ModelUsers;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class Users
{
    const ACTIVE = 1;
    public ModelUsers $users;
    public Countries $countries;
    public Interests $interests;

    public function __construct(ModelUsers $user, Countries $country, Interests $interest)
    {
        $this->users = $user;
        $this->countries = $country;
        $this->interests = $interest;
    }

    public static function sendCode($email, $method)
    {
        $user = ModelUsers::where('email', $email)->first();
        $mailLog = new Maillogs();
        if ($mailLog->where('email', $email)->whereDate('created_at', Carbon::now())->count() >= 3) {
            return [
                'message' => Lang::get('overlander.users::lang.user.sendcode_message.daily_limit')
            ];
        }
        if (Carbon::now()->diffInMinutes($user['send_mail_at']) < 1 && $user['verification_code'] != null) {
            return [
                'message' => Lang::get('overlander.users::lang.user.sendcode_message.send_times')
            ];
        }
        $code = General::generateRandomCode();
        $message = Lang::get('overlander.users::lang.user.sendcode_message.verify', ['code' => $code]);
        Mail::sendTo($email, 'overlander.general::mail.exists_verify', ['content' => $message]);
        $user->verification_code = $code;
        $mailLog->email = $email;
        $mailLog->content = $message;
        $mailLog->method = $method;
        $mailLog->save();
        $user->send_mail_at = Carbon::now()->toDateTimeString();
        $user->save();
        return [
            'message' => Lang::get('overlander.users::lang.user.sendcode_message.success')
        ];
    }

    public function checkExist($param)
    {
        $messages = '';
        $data = null;
        if (!empty($param['email'])) {
            $data = $this->users->where('email', $param['email'])->first();
            if ($data != null) {
                $messages = [
                    'email' => 'The email address already existed.',
                ];
            }
        }
        if (!empty($param['phone']) && $data != null) {
            if ($this->users->where('phone', $param['phone'])->first() != null) {
                $messages = [
                    'email' => 'The email address already existed.',
                    'phone' => 'The phone number already existed.',
                ];
            }
        }
        if (!empty($param['phone']) && $data == null) {
            $data = $this->users->where('phone', $param['phone'])->first();
            if (!empty($data)) {
                $messages = [
                    'phone' => 'The phone number already existed.',
                ];
            }
        }
        if (!empty($param['member_no'])) {
            $data = $this->users->where('member_no', $param['member_no'])->first();
            if (empty($data)) {
                $messages = [
                    'member_no' => 'The member number is not exists.',
                ];
            }
        }

        return $messages;
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
            'member_no' => $users->member_no . $users->member_prefix,
            'first_name' => $users->first_name,
            'last_name' => $users->last_name,
            'phone' => $users->phone,
            'password' => $users->password,
            'country' => $users->country_id,
            'email' => $users->email,
            'month' => $users->month,
            'year' => $users->year,
            'gender' => $users->gender,
            'interests' => $users->interests,
            'points' => $users->points,
            'membership_tier_id' => $users->points,
            'address' => $users->address,
            'is_existing_member' => $users->is_existing_member,
            'status' => $users->status,
            'active_date' => $users->active_date,
            'send_mail_at' => $users->send_mail_at,
        ];
    }

    public function getByEmail($email)
    {
        try {
            $data = null;
            $user = $this->users->getByEmail($email)->first();
            dd($user->member_prefix);
            if (!empty($user)) {
                $data = $this->convertData($user);
            }
            return $data;
        } catch (Exception $th) {
            throw new BadRequestHttpException($th->getMessage());
        }
    }

    public function create($data)
    {
        $data = $this->checkEmptyData($data);
        $user = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'country_id' => $this->countries->where('country', $data['country'])->first()['id'],
            'email' => $data['email'],
            'month' => $data['month'] ?? '1',
            'year' => $data['year'],
            'gender' => $data['gender'],
            'mail_receive' => $data['mail_receive'],
            'e_newsletter' => $data['e_newsletter'],
            'interests' => $data['interests'],
            'join_date' => Carbon::now()->format('Y-m-d'),
            'validity_date' => Carbon::now()->addMonth(3)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
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

    /**
     * @param $data
     * @return mixed
     */
    public function checkEmptyData($data)
    {
        if (empty($data['interests'])) {
            $data['interests'] = ' ';
        } else {
            $interest = [];
            foreach ($data['interests'] as $key => $value) {
                $interest[$key] = $this->interests->where('name', $value)->first()['id'];
            }
            $data['interests'] = implode(',', $interest);
        }
        if (empty($data['month'])) {
            $data['month'] = 1;
        }
        if (empty($data['year'])) {
            $data['year'] = (int)Carbon::now()->format('Y') - 80;
        }
        if ($data['gender'] == "") {
            $data['gender'] = null;
        }
        return $data;
    }

    public function resetPassword($newPassword, $confirmPassword, $email)
    {
        if ($newPassword == $confirmPassword) {
            $user = $this->users->where('email', $email)->first();
            $user->password = $newPassword;
            $user->save();
            return [
                'message' => Lang::get('overlander.users::lang.user.reset.success'),
            ];
        }
        return [
            'message' => Lang::get('overlander.users::lang.user.reset.failed'),
        ];
    }

    public function update($data)
    {
        $data = $this->checkEmptyData($data);
        $interests = function () use ($data) {
            $interest = [];
            foreach ($data['interests'] as $key => $value) {
                $interest[$key] = $this->interests->where('name', $value)->first()['id'];
            }
            return $interest;
        };
        $updateUser = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'country_id' => $this->countries->where('country', $data['country'])->first()['id'],
            'email' => $data['email'],
            'month' => $data['month'],
            'year' => $data['year'],
            'gender' => $data['gender'],
            'interest_id' => implode(",", $interests()),
            'updated_at' => General::getCurrentDay(),
        ];
        try {
            $user = $this->users->where('email', $data['email'])->first();
            $user->fill($updateUser);
            $user->save();
            return [
                'message' => 'Update Successfully!!!',
            ];
        } catch (Exception $th) {
            throw new BadRequestHttpException($th->getMessage());
        }
    }

    public function verifyCode($email, $code)
    {
        $user = $this->users->where('email', $email)->first();
        if (Carbon::now()->diffInMinutes($user['send_mail_at']) > 10) {
            $user->send_mail_at = null;
            $user->save();
            return [
                'message' => Lang::get('overlander.users::lang.user.verify_message.expired')
            ];
        }

        if ($user['verification_code'] == $code) {
            $user->verification_code = null;
            $user->send_mail_at = null;
            if ($user['status'] != self::ACTIVE) {
                $user->status = self::ACTIVE;
                $user->active_date = Carbon::now();
            }
            $user->save();
            return [
                'message' => Lang::get('overlander.users::lang.user.verify_message.success')
            ];
        }
        return [
            'message' => Lang::get('overlander.users::lang.user.verify_message.failed')
        ];
    }

    public function login($param)
    {
        if (!empty($param['member_no'])) {
            $member_no = preg_replace('/[^0-9]/', '', $param['member_no']);
            $data = $this->users->where('member_no', $member_no)->first();
        } elseif (!empty($param['email'])) {
            $data = $this->users->where('email', $param['email'])->first();
        }
        if ($data == null) {
            return [
                'message' => Lang::get('overlander.users::lang.user.login.failed'),
            ];
        } else {
            if ($param['password'] == $data['password']) {
                return [
                    'message' => Lang::get('overlander.users::lang.user.login.success'),
                ];
            }
            return [
                'message' => Lang::get('overlander.users::lang.user.login.wrong'),
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
