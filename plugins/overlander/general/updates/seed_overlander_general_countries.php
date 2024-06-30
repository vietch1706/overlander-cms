<?php

namespace Overlander\General\Updates;

use Overlander\General\Models\Countries;
use Seeder;

/**
 * CountriesSeeders
 */
class SeedOverlanderGeneralCountries extends Seeder
{
    /**
     * run the database seeds.
     */
    function run()
    {
        $countries = [
            [
                'country' => 'Hong Kong',
                'code' => '852',
                'image' => 'hk'
            ],
            [
                'country' => 'China',
                'code' => '86',
                'image' => 'cn'
            ],
            [
                'country' => 'Macau',
                'code' => '853',
                'image' => 'mo'
            ],
            [
                'country' => 'Japan',
                'code' => '81',
                'image' => 'jp'
            ],
            [
                'country' => 'TAIWAN',
                'code' => '886',
                'image' => 'tw'
            ],
            [
                'country' => 'Singapore',
                'code' => '65',
                'image' => 'sg'
            ],
            [
                'country' => 'PHILIPPINES',
                'code' => '63',
                'image' => 'ph'
            ],
            [
                'country' => 'Malaysia',
                'code' => '60',
                'image' => 'my'
            ],
            [
                'country' => 'New Zealand',
                'code' => '64',
                'image' => 'nz'
            ],
            [
                'country' => 'Australia',
                'code' => '61',
                'image' => 'au'
            ],
            [
                'country' => 'Canada',
                'code' => '1',
                'image' => 'ca'
            ],
            [
                'country' => 'USA',
                'code' => '1',
                'image' => 'us'
            ],
            [
                'country' => 'United Kingdom',
                'code' => '44',
                'image' => 'gb'
            ],
        ];

        foreach ($countries as $key => $value) {
            $country = new Countries();
            $country->country = $value['country'];
            $country->code = $value['code'];
            $country->image = $value['image'];
            $country->save();
        }
    }
}
