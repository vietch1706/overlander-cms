<?php

namespace Overlander\Users\Models;

use Model;

/**
 * Model
 */
class MembershipTier extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_users_membership_tier';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'name' => 'required',
        'logo' => 'required',
        'points_required' => 'required',
        'points_remain' => 'required',
        'period' => 'required',
    ];
}
