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
        'id' => 1,
        'name' => 'Temporary',
        'logo' => '/MembershipTier/Temporary.png',
        'points_required' => '0',
        'points_remain' => '0',
        'period' => '3 Months',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ],
      [
        'id' => 2,
        'name' => 'Ordinary',
        'logo' => '/MembershipTier/Ordinary.png',
        'points_required' => '0',
        'points_remain' => '0',
        'period' => '4 Years ',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ],
      [
        'id' => 3,
        'name' => 'VIP',
        'logo' => '/MembershipTier/VIP.png',
        'points_required' => '5000',
        'points_remain' => '5000',
        'period' => '4 Years',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ],
      [
        'id' => 4,
        'name' => 'Gold',
        'logo' => '/MembershipTier/Gold.png',
        'points_required' => '22000',
        'points_remain' => '22000',
        'period' => '4 Years',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ],
      [
        'id' => 5,
        'name' => 'Platinum',
        'logo' => '/MembershipTier/Platinum.png',
        'points_required' => '0',
        'points_remain' => '0',
        'period' => '4 Years',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ],
      [
        'id' => 6,
        'name' => 'Premier',
        'logo' => '/MembershipTier/Premier.png',
        'points_required' => '0',
        'points_remain' => '0',
        'period' => '4 Years',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ]
    ];
    MembershipTier::insert($membershiptier);
  }
}
