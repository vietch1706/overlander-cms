<?php

namespace Overlander\General\Updates;

use Overlander\General\Helper\General;
use Overlander\General\Models\MembershipTier;
use Seeder;

/**
 * MembershipTierSeeders
 */
class SeedOverlanderGeneralMembershipTier extends Seeder
{
    /**
     * run the database seeds.
     */
    const GROUP_AUTOMATIC = 0;
    const GROUP_MANUAL = 1;
    public function run()
    {
        $membershiptier = [
            [
                'name' => 'Temporary',
                'logo' => '/MembershipTier/Temporary.png',
                'points_required' => '0',
                'points_remain' => '0',
                'period' => '3',
                'slug' => 'temporary',
                'group' => self::GROUP_AUTOMATIC,
                'created_at' => General::getCurrentDay(),
                'updated_at' => General::getCurrentDay(),
            ],
            [
                'name' => 'Ordinary',
                'logo' => '/MembershipTier/Ordinary.png',
                'points_required' => '1',
                'points_remain' => '1',
                'period' => '48',
                'slug' => 'ordinary',
                'group' => self::GROUP_AUTOMATIC,
                'created_at' => General::getCurrentDay(),
                'updated_at' => General::getCurrentDay(),
            ],
            [
                'name' => 'VIP',
                'logo' => '/MembershipTier/VIP.png',
                'points_required' => '5000',
                'points_remain' => '5000',
                'period' => '48',
                'slug' => 'vip',
                'group' => self::GROUP_AUTOMATIC,
                'created_at' => General::getCurrentDay(),
                'updated_at' => General::getCurrentDay(),
            ],
            [
                'name' => 'Gold',
                'logo' => '/MembershipTier/Gold.png',
                'points_required' => '22000',
                'points_remain' => '22000',
                'period' => '48',
                'slug' => 'gold',
                'group' => self::GROUP_AUTOMATIC,
                'created_at' => General::getCurrentDay(),
                'updated_at' => General::getCurrentDay(),
            ],
            [
                'name' => 'Platinum',
                'logo' => '/MembershipTier/Platinum.png',
                'points_required' => '0',
                'points_remain' => '0',
                'period' => '48',
                'slug' => 'platinum',
                'group' => self::GROUP_MANUAL,
                'created_at' => General::getCurrentDay(),
                'updated_at' => General::getCurrentDay(),
            ],
            [
                'name' => 'Premier',
                'logo' => '/MembershipTier/Premier.png',
                'points_required' => '0',
                'points_remain' => '0',
                'period' => '48',
                'slug' => 'premier',
                'group' => self::GROUP_MANUAL,
                'created_at' => General::getCurrentDay(),
                'updated_at' => General::getCurrentDay(),
            ]
        ];
        MembershipTier::insert($membershiptier);
    }
}
