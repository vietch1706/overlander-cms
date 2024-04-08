<?php

namespace Overlander\Users\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Model;
use Overlander\Users\Controllers\MembershipTier;
use Overlander\Users\Controllers\Transaction;

/**
 * Model
 */
class Users extends Model
{
    use \October\Rain\Database\Traits\Validation;
    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;
    const EXIST_MEMBER = 1;
    const NO_EXIST_MEMBER = 0;
    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_users_users';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'vip' => 'required', 'unique:overlander_users_users,vip',
        'first_name' => 'required',
        'last_name' => 'required',
        'phone' => 'required', 'unique:overlander_users_users,phone', 'regex:/(84|0[3|5|7|8|9])+([0-9]{8})/', 'min_digits:10',
        'password' => 'required',
        'country' => 'required',
        'email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',
        'birthday' => 'required',
        'gender' => 'required',
        'is_existing' => 'required',
        'points' => 'required',
        'membership_tier_id' => 'required',
        'published_date' => 'required|before:expired_date',
        'expired_date' => 'required|after:tommorrow'
    ];

    public function getGenderOptions()
    {
        return [
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
        ];
    }

    public function getExistMemberOptions()
    {
        return [
            self::EXIST_MEMBER => 'Exist',
            self::NO_EXIST_MEMBER => 'No Exist',
        ];
    }

    public $belongsTo = [
        'membership_tier_id' => 'Overlander\Users\Models\MembershipTier'
    ];

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeGetById($query, $id)
    {
        return $query->where('id', $id);
    }
}
