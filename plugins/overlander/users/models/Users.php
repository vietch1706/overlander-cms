<?php

namespace Overlander\Users\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Model;
use October\Rain\Database\Traits\Validation;
use Overlander\General\Models\Countries;
use Overlander\General\Models\Interests;
use Overlander\Users\Controllers\Transaction;
use Backend\Models\User as BackendUser;

/**
 * Model
 */
class Users extends BackendUser
{
    use Validation;
    use Notifiable;

    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;
    const GENDER_OTHER = '';
    const EXIST_MEMBER = 1;
    const NORMAL_MEMBER = 0;
    const ACTIVE = 1;
    const INACTIVE = 0;
    const YES = 1;
    const NO = 0;

    const MONTH = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

    public $attributes = [
        'is_existing_member' => '0',
        'status' => '0',
        'membership_tier_id' => '1',
        'points_sum' => 0,
        'gender' => null,
        'interests' => null,
        'password' => '123456789'
    ];
    /**
     * @var string table in the database used by the model.
     */
    //    public $table = 'overlander_users_users';
    /**
     * @var array rules for validation.
     */
    public $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'phone' => ['required', 'unique:overlander_users_users,phone', 'integer'],
        'country_id' => 'required',
        'email' => ['required', 'email', 'unique:overlander_users_users,email'],
        'month' => ['integer', 'between:0,12'],
        'year' => ['integer'],
        'join_date' => ['date', 'before:validity_date',],
        'validity_date' => ['date', 'after:join_date',]
    ];
    public $belongsTo = [
        'membership_tier' => [MembershipTier::class, 'key' => 'membership_tier_id'],
        'country' => [Countries::class, 'key' => 'country_id'],
    ];
    /**
     * @var mixed|string
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'password',
        'country_id',
        'email',
        'month',
        'year',
        'gender',
        'interests',
        'is_existing_member',
        'status',
        'active_date',
        'points_sum',
        'membership_tier_id',
        'send_mail_at',
        'verification_code',
        'join_date',
        'validity_date',
        'district',
        'address',
        'e_newsletter',
        'mail_receive',
    ];

    public function getFullMemberNumberAttribute()
    {
        return $this->member_no . $this->member_prefix;
    }

    public function beforeValidate(){
        if (!$this->login) {
            $this->login = str_random(10);
        }
    }
    public function beforeCreate()
    {
        $lastestUser = $this->orderBy('member_no', 'desc')->first();
        if (empty($this->member_no) && empty($this->member_prefix)) {
            $this->member_prefix = 'A';
            if (!empty($lastestUser)) {
                $this->member_no = 100000 + 1;
            } else {
                $this->member_no = 100000;
            }
        }
    }

    public function getGenderOptions()
    {
        return [
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
            self::GENDER_OTHER => 'Other'
        ];
    }

    public function getENewsletterOptions()
    {
        return [
            self::YES => 'Yes',
            self::NO => 'No',
        ];
    }

    public function getMailReceiveOptions()
    {
        return [
            self::YES => 'Yes',
            self::NO => 'No',
        ];
    }

    public function getMonthOptions()
    {
        return [
            self::MONTH[0] => 'January',
            self::MONTH[1] => 'February',
            self::MONTH[2] => 'March',
            self::MONTH[3] => 'April',
            self::MONTH[4] => 'May',
            self::MONTH[5] => 'June',
            self::MONTH[6] => 'July',
            self::MONTH[7] => 'August',
            self::MONTH[8] => 'September',
            self::MONTH[9] => 'October',
            self::MONTH[10] => 'November',
            self::MONTH[11] => 'December',
        ];
    }

    public function getYearOptions()
    {
        $j = 0;
        for ($i = ((int)Carbon::now()->format('Y')) - 80; $i <= ((int)Carbon::now()->format('Y')); $i++) {
            $years[$i] = $i;
            $j++;
        }
        return $years;
    }

    public function getMemberPrefixOptions()
    {
        return [
            'A',
            'S',
            'P'
        ];
    }

    public function getIsExistingMemberOptions()
    {
        return [
            self::EXIST_MEMBER => 'Exist Member',
            self::NORMAL_MEMBER => 'Normal Member',
        ];
    }

    public function getStatusOptions()
    {
        return [
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        ];
    }

    public function listInterest()
    {
        return Interests::getInterestName();
    }

    public function getInterestsDataAttribute()
    {
        $interests = explode(",", $this->interests);
        $data = Interests::whereIn('id', $interests)->get();
        $numItems = count($data);
        $i = 0;
        $result = "";
        foreach ($data as $value) {
            if (++$i === $numItems) {
                $result .= $value->name;
            } else {
                $result .= $value->name . ', ';
            }
        }
        return title_case($result);
    }

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeGetByMemberNumber($query, $memberNumber)
    {
        return $query->where('member_no', $memberNumber);
    }

    public function scopeGetById($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeGetByEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    public function scopeGetByPhone($query, $phone)
    {
        return $query->where('phone', $phone);
    }
}
