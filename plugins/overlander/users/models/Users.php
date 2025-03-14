<?php

namespace Overlander\Users\Models;

use Backend\Models\User as BackendUser;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use October\Rain\Database\Traits\Validation;
use Overlander\General\Models\Countries;
use Overlander\General\Models\Interests;
use Overlander\General\Models\MembershipTier;
use Overlander\Transaction\Models\PointHistory;


/**
 * Model
 */
class Users extends BackendUser
{
    use Validation;
    use Notifiable;

    public const ROLE_ADMIN_ID = 1;
    public const ROLE_ADMIN_CODE = 'admin';
    public const ROLE_EMPLOYEE_ID = 2;
    public const ROLE_EMPLOYEE_CODE = 'employee';
    public const ROLE_CUSTOMER_ID = 3;
    public const ROLE_CUSTOMER_CODE = 'customer';
    public const GENDER_MALE = 0;
    public const GENDER_FEMALE = 1;
    public const GENDER_OTHER = null;
    public const EXIST_MEMBER = 1;
    public const NORMAL_MEMBER = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public const IS_ACTIVATED_ACTIVATE = 1;
    public const IS_ACTIVATED_SUSPEND = 0;

    public const YES = 1;
    public const NO = 0;
    public const DEFAULT_POINTS_SUM = 0;

    public const MONTH = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

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
        'phone' => 'required|numeric|regex:/[0-9]/|not_regex:/[a-z]/',
        'country_id' => 'required',
        'email' => ['required', 'email', 'unique:backend_users,email'],
        'month' => ['integer', 'between:0,12'],
        'year' => ['integer'],
        'join_date' => ['date', 'before:validity_date',],
        'validity_date' => ['date', 'after:join_date',]
    ];
    public $belongsTo = [
        'membership_tier' => [
            MembershipTier::class,
            'key' => 'membership_tier_id'
        ],
        'country' => [
            Countries::class,
            'key' => 'country_id'
        ],
    ];

    public $hasMany = [
        'point_history' => [
            PointHistory::class,
            'key' => 'user_id'
        ],
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
        'points_sum',
        'membership_tier_id',
        'send_mail_at',
        'join_date',
        'validity_date',
        'district',
        'address',
        'e_newsletter',
        'mail_receive',
    ];

    public function getFullMemberNoAttribute()
    {
        return $this->member_no . $this->member_prefix;
    }

    public function getPhoneNumberAttribute()
    {
        return $this->phone_area_code . $this->phone;
    }

    public function getBirthdayAttribute()
    {
        if ($this->month == null || $this->year == null) {
            return '';
        }
        return $this->month . '-' .$this->year;
    }

    public function beforeValidate()
    {
        if (!$this->login) {
            $this->login = str_random(10);
        }
    }

    public function getPhoneAreaCodeOptions()
    {
        return Countries::all()->lists('code', 'code');
    }

    public function afterCreate()
    {
        $this->role_id = self::ROLE_CUSTOMER_ID;
        if (empty($this->member_no) && empty($this->member_prefix)) {
            $this->member_prefix = 'A';
            $this->member_no = str_pad($this->id, 6, '0', STR_PAD_LEFT);
            $this->save();
        }
        $this->member_no = str_pad($this->id, 6, '0', STR_PAD_LEFT);
        $this->is_activated = self::IS_ACTIVATED_ACTIVATE;
        $this->save();
    }

    public function getIsActivatedOptions()
    {
        return [
            self::IS_ACTIVATED_ACTIVATE => 'Activate',
            self::IS_ACTIVATED_SUSPEND => 'Suspend',
        ];
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
        $years = [];
        for ($i = ((int)Carbon::now()->format('Y')); $i >= ((int)Carbon::now()->format('Y') - 80); $i--) {
            $years[$j] = $i;
            $j++;
        }
        return $years;
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
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
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
        return $query->where(DB::raw('concat(phone_area_code, phone)'), $phone);
    }
}
