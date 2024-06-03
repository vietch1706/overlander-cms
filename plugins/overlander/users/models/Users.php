<?php

namespace Overlander\Users\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Model;
use Overlander\General\Models\Countries;
use Overlander\Users\Models\MembershipTier;
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
    const EXIST_MEMBER = 1;
    const NORMAL_MEMBER = 0;
    const ACTIVE = 1;
    const INACTIVE = 0;
    protected $fillable = [
        'member_no',
        'first_name',
        'last_name',
        'phone',
        'password',
        'country_id',
        'email',
        'birthday',
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
        'phone' => ['required', 'unique:overlander_users_users,phone', 'regex:/(\+84|0[3|5|7|8|9])+([0-9]{8})/'],
        'password' => 'required',
        'country_id' => 'required',
        'email' => ['required', 'email', 'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', 'unique:overlander_users_users,email'],
        'birthday' => 'required',
        'published_date' => ['required', 'before:expired_date'],
        'expired_date' => ['required', 'after:published_date'],
    ];

    public function getGenderOptions()
    {
        return [
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
        ];
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

    public $belongsTo = [
        'membership_tier' => [MembershipTier::class, 'key' => 'membership_tier_id'],
        'country' =>  [Countries::class, 'key' => 'country_id']
    ];


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
