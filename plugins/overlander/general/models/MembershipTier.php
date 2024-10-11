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

    public const ID_ORDINARY = 2;
    public const ID_GOLD = 4;
    public const SLUG_TEMPORARY = 'temporary';
    public const SLUG_ORDINARY = 'ordinary';
    public const SLUG_VIP = 'vip';
    public const SLUG_GOLD = 'gold';
    public const SLUG_PLATINUM = 'platinum';
    public const SLUG_PREMIER = 'premier';

    public const GROUP_AUTOMATIC = 0;
    public const GROUP_MANUAL = 1;


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

    public static function getPreviousMembership($currentMembershipId)
    {
        if ($currentMembershipId == self::ID_ORDINARY) {
            return self::where('id', self::ID_ORDINARY)->select('id', 'period')->first();
        }
        $previousMembership = self::select('id', 'slug', 'period')
            ->whereNot('id', $currentMembershipId)
            ->where('group', self::GROUP_AUTOMATIC)
            ->where('id', '<', $currentMembershipId)
            ->orderBy('id', 'desc')
            ->first();
        if ($previousMembership->slug == self::SLUG_TEMPORARY) {
            return null;
        }
        return $previousMembership;
    }

    public function scopeGetById($query, $id)
    {
        return $query->where('id', $id);
    }
}
