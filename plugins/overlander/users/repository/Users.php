<?php

namespace Overlander\Users\Repository;

use Backend\Facades\BackendAuth;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Lang;
use Legato\Api\Exceptions\BadRequestException;
use Legato\Api\Exceptions\NotFoundException;
use Overlander\General\Helper\General;
use Overlander\General\Models\Countries;
use Overlander\General\Models\Interests;
use Overlander\General\Models\MembershipTier;
use Overlander\Logs\Models\Maillogs;
use Overlander\Users\Models\Users as ModelUsers;

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
        try {
            if (empty($user)) {
                throw new BadRequestException(Lang::get('overlander.users::lang.user.not_found'));
            }
            $mailLog = new Maillogs();
            if ($mailLog->where('email', $email)->whereDate('created_at', Carbon::now())->count() >= 3) {
                throw new BadRequestException(Lang::get('overlander.users::lang.user.send_code_message.daily_limit'));
            }
            if (Carbon::now()->diffInMinutes($user->send_mail_at) < 1 && $user->activation_code != null) {
                throw new BadRequestException(Lang::get('overlander.users::lang.user.send_code_message.send_times'));
            }
            $code = General::generateRandomCode();
            $message = Lang::get('overlander.users::lang.user.send_code_message.verify', ['code' => $code]);
            Mail::sendTo($email, 'overlander.general::mail.exists_verify', ['content' => $message]);
            $user->activation_code = $code;
            $mailLog->email = $email;
            $mailLog->content = $message;
            $mailLog->method = $method;
            $mailLog->save();
            $user->send_mail_at = Carbon::now()->toDateTimeString();
            $user->save();
            return [
                'message' => Lang::get('overlander.users::lang.user.send_code_message.success')
            ];
        } catch (Exception $th) {
            throw new BadRequestException($th->getMessage());
        }
    }

    public static function convertData($users)
    {
        $country = Countries::where('id', $users->country_id)->first();
        $membershipTier = MembershipTier::where('id', $users->membership_tier_id)->first();
        return [
            'member_no' => $users->member_no . $users->member_prefix,
            'first_name' => $users->first_name,
            'last_name' => $users->last_name,
            'phone_area_code' => '+' . $users->phone_area_code,
            'phone' => $users->phone,
            'password' => $users->password,
            'country' => $country === null ? '' : $country->country,
            'email' => $users->email,
            'month' => strval($users->month),
            'year' => strval($users->year),
            'gender' => str($users->gender),
            'interests' => array_map('intval', explode(",", $users->interests)),
            'points' => $users->points,
            'membership_tier' => $membershipTier === null ? '' : $membershipTier->name,
            'address' => $users->address,
            'member_type' => $users->is_existing_member,
            'status' => $users->is_activated,
            'active_date' => $users->activated_at,
            'e_newsletter' => $users->e_newsletter === 1,
            'mail_receive' => $users->mail_receive === 1,
        ];
    }

    public function update($params)
    {
        $user = $this->users->where(DB::raw('concat(phone_area_code, phone)'), $params['phone'])->first();
        if (empty($user)) {
            $user = $this->users->where('email', $params['email'])->first();
        }
        if (empty($user)) {
            throw new NotFoundException(Lang::get('overlander.users::lang.user.not_found'));
        }
        $params['interests'] = implode(",", $params['interests']);
        // Save user into backend_users table
        $user->first_name = $params['first_name'];
        $user->last_name = $params['last_name'];
        $user->phone = $params['phone'];
        $user->phone_area_code = $params['phone_area_code'];
        $user->password = $params['password'] === "" ? "" : $params['password'];
        $user->password_confirmation = $params['password_confirmation'];
        $user->email = $params['email'];
        $user->country_id = $this->countries->where('country', $params['country'])->first()['id'];
        $user->district = $params['district'] ?? "";
        $user->address = $params['address'] ?? "";
        $user->month = $params['month'] === "" ? '1' : $params['month'];
        $user->year = $params['year'] === "" ? ((int)Carbon::now()->format('Y')) : $params['year'];
        $user->gender = $params['gender'] === "" ? null : $params['gender'];
        $user->mail_receive = $params['mail_receive'];
        $user->e_newsletter = $params['e_newsletter'];
        $user->interests = $params['interests'];
        $user->updated_at = Carbon::now();
        try {
            $user->save();
            return [
                'message' => Lang::get('overlander.users::lang.user.update.success'),
            ];
        } catch (Exception $th) {
            throw new BadRequestException($th->getMessage());
        }
    }

    public function checkCode($email, $code)
    {
        $user = $this->users->where('email', $email)->first();
        try {
            if (Carbon::now()->diffInMinutes($user->send_mail_at) > 10) {
                throw new BadRequestException(Lang::get('overlander.users::lang.user.verify_message.expired'));
            }
            if ($user->activation_code != $code) {
                throw new BadRequestException(Lang::get('overlander.users::lang.user.verify_message.failed'));
            }
            if ($user->is_activated != self::ACTIVE) {
                $user->is_activated = self::ACTIVE;
                $user->activated_at = Carbon::now();
            }
            $user->activation_code = null;
            $user->send_mail_at = null;
            $user->save();
        } catch (Exception $th) {
            throw new BadRequestException($th->getMessage());
        }
        return [
            'message' => Lang::get('overlander.users::lang.user.verify_message.success')
        ];
    }


    public function getUser()
    {
        $user = BackendAuth::getUser();
        return $user;
    }
}
