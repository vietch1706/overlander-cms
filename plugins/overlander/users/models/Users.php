<?php

namespace Overlander\Users\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Model;
use Overlander\General\Models\Countries;
use Overlander\General\Models\Interests;
use Overlander\Users\Controllers\Transaction;

/**
 * Model
 */
class Users extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use Notifiable;

    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;
    const GENDER_OTHER = '';
    const EXIST_MEMBER = 1;
    const NORMAL_MEMBER = 0;
    const ACTIVE = 1;
    const INACTIVE = 0;
    const MONTH = [null, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    public $attributes = [
        'is_existing_member' => '0',
        'is_active' => '0',
        'membership_tier_id' => '1',
        'points' => 0,
    ];
    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_users_users';
    /**
     * @var array rules for validation.
     */
    public $rules = [
        'member_no' => ['required', 'unique:overlander_users_users,member_no'],
        'member_no' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'phone' => ['required', 'unique:overlander_users_users,phone'],
        'password' => 'required',
        'country_id' => 'required',
        'email' => ['required', 'email', 'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', 'unique:overlander_users_users,email'],
        'month' => ['integer', 'between:0,12'],
        'year' => [],
        'published_date' => ['required', 'before:expired_date'],
        'expired_date' => ['required', 'after:published_date'],
    ];
    public $belongsTo = [
        'membership_tier' => [MembershipTier::class, 'key' => 'membership_tier_id'],
        'country' => [Countries::class, 'key' => 'country_id'],
    ];
    protected $fillable = [
        'member_no',
        'first_name',
        'last_name',
        'phone',
        'password',
        'country_id',
        'email',
        'month',
        'year',
        'gender',
        'interest',
        'is_existing_member',
        'is_active',
        'active_date',
        'points',
        'membership_tier_id',
        'published_date',
        'expired_date',
        'send_mail_at',
        'verification_code',
    ];

    public function getFullMemberNumberAttribute()
    {
        return $this->member_no . $this->member_prefix;
    }

    public function getGenderOptions()
    {
        return [
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
            self::GENDER_OTHER => 'Other'
        ];
    }

    public function getMonthOptions()
    {
        return [
            self::MONTH[0] => 'NONE',
            self::MONTH[1] => 'January',
            self::MONTH[2] => 'February',
            self::MONTH[3] => 'March',
            self::MONTH[4] => 'April',
            self::MONTH[5] => 'May',
            self::MONTH[6] => 'June',
            self::MONTH[7] => 'July',
            self::MONTH[8] => 'August',
            self::MONTH[9] => 'September',
            self::MONTH[10] => 'October',
            self::MONTH[11] => 'November',
            self::MONTH[12] => 'December',
        ];
    }

    public function getYearOptions()
    {
        $years = [0];
        $j = 1;
        for ($i = 1900; $i <= (((int)Carbon::now()->format('Y')) + 10); $i++) {
            $years[$j] = $i;
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

    public function getIsActiveOptions()
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

    public function ScopeGetByMemberNumber($query, $memberNumber)
    {
        return $query->where('member_no', $memberNumber);
    }

    public function ScopeGetById($query, $id)
    {
        return $query->where('id', $id);
    }

    public function ScopeGetByEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    public function ScopeGetByPhone($query, $phone)
    {
        return $query->where('phone', $phone);
    }
}
