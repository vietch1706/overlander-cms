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
                    $year = $birthday[2];
                    $month = $birthday[1];
                    $user->member_no = preg_replace('/[^0-9]/', '', $data['member_no']);
                    $user->member_prefix = preg_replace('/[^A-Z]/', '', $data['member_no']);
                    $user->first_name = $data['first_name'];
                    $user->last_name = $data['last_name'];
                    $user->phone = $data['phone'];
                    $user->email = $data['email'];
                    $user->gender = match ($data['gender']) {
                        'Male' => Users::GENDER_MALE,
                        'Female' => Users::GENDER_FEMALE,
                        default => Users::GENDER_OTHER,
                    };
                    $user->month = $month;
                    $user->year = $year;
                    $user->address = $data['address'];
                    $user->district = $data['district'];
                    $user->country_id = Countries::where('country', $data['country'])->first()['id'];
                    $user->e_newsletter = $data['e_newsletter'] === 'Yes' ? Users::YES : Users::NO;
                    $user->mail_receive = $data['mail_receive'] === 'Yes' ? Users::YES : Users::NO;
                    $user->join_date = Carbon::createFromFormat('d/m/Y', $data['join_date'])->toDate();
                    $user->validity_date = Carbon::createFromFormat('d/m/Y', $data['validity_date'])->toDate();
                    $user->membership_tier_id = MembershipTier::where('name', $data['membership_tier_name'])->first()->id;
                    $user->status = $data['status'] === 'Active' ? Users::STATUS_ACTIVE : Users::STATUS_INACTIVE;
                    $user->is_activated = Users::STATUS_ACTIVE;
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
