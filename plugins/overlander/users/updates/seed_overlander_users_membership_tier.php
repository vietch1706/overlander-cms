<?php

namespace Overlander\Users\Updates;

use Overlander\Users\Models\MembershipTier;
use Seeder;

/**
 * MembershipTierSeeders
 */
class SeedOverlanderUsersMembershipTier extends Seeder
{
  /**
   * run the database seeds.
   */
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
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ],
      [
        'name' => 'Ordinary',
        'logo' => '/MembershipTier/Ordinary.png',
        'points_required' => '0',
        'points_remain' => '0',
        'period' => '48',
        'slug' => 'ordinary',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ],
      [
        'name' => 'VIP',
        'logo' => '/MembershipTier/VIP.png',
        'points_required' => '5000',
        'points_remain' => '5000',
        'period' => '48',
        'slug' => 'vip',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ],
      [
        'name' => 'Gold',
        'logo' => '/MembershipTier/Gold.png',
        'points_required' => '22000',
        'points_remain' => '22000',
        'period' => '48',
        'slug' => 'gold',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ],
      [
        'name' => 'Platinum',
        'logo' => '/MembershipTier/Platinum.png',
        'points_required' => '0',
        'points_remain' => '0',
        'period' => '48',
        'slug' => 'platinum',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ],
      [
        'name' => 'Premier',
        'logo' => '/MembershipTier/Premier.png',
        'points_required' => '0',
        'points_remain' => '0',
        'period' => '48',
        'slug' => 'premier',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ]
    ];
    MembershipTier::insert($membershiptier);
  }
}
