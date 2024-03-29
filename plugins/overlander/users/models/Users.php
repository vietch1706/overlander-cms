<?php

namespace Overlander\Users\Models;

use Model;

/**
 * Model
 */
class Users extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_users_users';

    /**
     * @var array rules for validation.
     */
    public $rules = [
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

    public function scopeGetById($query, $id)
    {
        return $query->where('id', $id);
    }
}
