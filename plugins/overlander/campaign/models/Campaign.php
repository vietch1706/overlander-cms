<?php namespace Overlander\Campaign\Models;

use Model;
use Overlander\General\Models\Brands;
use Overlander\General\Models\Countries;
use Overlander\General\Models\MembershipTier;

/**
 * Model
 */
class Campaign extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public const STATUS_ACTIVATE = 1;
    public const STATUS_SUSPEND = 0;
    public const TARGET_MEMBERSHIP = 0;
    public const TARGET_SHOP = 1;
    public const TARGET_BRAND = 2;
    public const TARGET_SKU = 3;

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_campaign_campaign';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'title' => 'required',
        'multiplier' => 'required',
        'target' => 'required',
        'start_date' => 'required|before:end_date',
        'end_date' => 'required|after:start_date',
    ];
    public $belongsTo = [
        'membership_tier' => [MembershipTier::class, 'key' => 'membership_tier_id'],
        'brand' => [Brands::class, 'key' => 'brand_id'],
    ];
    public function getStatusOptions()
    {
        return [
            self::STATUS_ACTIVATE => 'Activate',
            self::STATUS_SUSPEND => 'Suspend',
        ];
    }

    public function getTargetOptions()
    {
        return [
            self::TARGET_MEMBERSHIP => 'Membership',
            self::TARGET_SHOP => 'Shop',
            self::TARGET_BRAND => 'Brand',
            self::TARGET_SKU => 'SKU',
        ];
    }
}
