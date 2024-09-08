<?php

namespace Overlander\General\Models;

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
    public $table = 'overlander_general_membership_tier';

    const SLUG_ORDINARY = 'ordinary';
    const SLUG_VIP = 'vip';
    const SLUG_GOLD = 'gold';

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
