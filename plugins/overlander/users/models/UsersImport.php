<?php

namespace Overlander\Users\Models;

use Backend\Models\ImportModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Overlander\General\Models\Countries;
use Overlander\General\Models\MembershipTier;

class UsersImport extends ImportModel
{
    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;
    const GENDER_OTHER = '';
    const EXIST_MEMBER = 1;
    const NORMAL_MEMBER = 0;
    const ACTIVE = 1;
    const INACTIVE = 0;
    const YES = 1;
    const NO = 0;
    /**
     * @inheritDoc
     */
    public $rules = [
    ];

    public function importData($results, $sessionKey = null)
    {
        // TODO: Implement importData() method.
        foreach ($results as $row => $data) {
            $birthday = explode('/', $data['birthday']);
            $existUser = Users::where(DB::raw('concat(member_no, member_prefix)'), $data['member_no'])->first();
            if (empty($existUser)) {
                try {
                    $user = new Users();
                    $countries = new Countries();
                    $year = $birthday[2];
                    $month = $birthday[1];
                    $user->member_no = preg_replace('/[^0-9]/', '', $data['member_no']);
                    $user->member_prefix = preg_replace('/[^A-Z]/', '', $data['member_no']);
                    $user->first_name = $data['first_name'];
                    $user->last_name = $data['last_name'];
                    $user->phone = $data['phone'];
                    $user->email = $data['email'];
                    $user->gender = match ($data['gender']) {
                        'Male' => self::GENDER_MALE,
                        'Female' => self::GENDER_FEMALE,
                        default => self::GENDER_OTHER,
                    };
                    $user->month = $month;
                    $user->year = $year;
                    $user->address = $data['address'];
                    $user->district = $data['district'];
                    $user->country_id = $countries->where('country', $data['country'])->first()['id'];
                    $user->e_newsletter = $data['e_newsletter'] === 'Yes' ? self::YES : self::NO;
                    $user->mail_receive = $data['mail_receive'] === 'Yes' ? self::YES : self::NO;
                    $user->join_date = Carbon::createFromFormat('d/m/Y', $data['join_date'])->toDate();
                    $user->validity_date = Carbon::createFromFormat('d/m/Y', $data['validity_date'])->toDate();
                    $user->membership_tier_id = MembershipTier::where('name', $data['membership_tier_name'])->first()->id;
                    $user->is_activated = $data['status'] === 'Active' ? self::ACTIVE : self::NO;
                    $user->activated_at = Carbon::now();
                    $user->interests = $data['interests_data'];
                    $user->sales_amounts = $data['sales_amounts'];
                    $user->points_sum = $data['points_sum'];
                    $user->created_at = Carbon::now();
                    $user->updated_at = Carbon::now();
                    $user->save();
                    $this->logCreated();
                } catch (Exception $ex) {
                    $this->logError($row, $ex->getMessage());
                }
            }

        }

    }
}
