<?php

namespace Overlander\General\Updates;

use Overlander\General\Models\Interests;
use Seeder;

class seed_overlander_general_interests extends Seeder
{
    /**
     * InterestsSeeders
     */
    function run()
    {
        /**
         * run the database seeds.
         */
        $interests = [
            [
                'name' => 'Single/Two Person Camping'
            ], [
                'name' => 'Weekend Hikes'
            ], [
                'name' => 'Long Distance Hikes'
            ], [
                'name' => 'Family Camping'
            ], [
                'name' => 'Light Camping'
            ], [
                'name' => 'Car Camping'
            ], [
                'name' => 'Overseas Camping,'
            ], [
                'name' => 'Overseas Travel'
            ], [
                'name' => 'Backpacking Travel'
            ], [
                'name' => 'Cultural and Ecological Tours'
            ], [
                'name' => 'Ecological Photography'
            ], [
                'name' => 'Short/Recreational Excursions'
            ], [
                'name' => 'Landscape Photography'
            ], [
                'name' => 'Road Running'
            ], [
                'name' => 'Trail Running'
            ], [
                'name' => 'Ultra-Distance Trail Running'
            ], [
                'name' => 'Virtual Running'
            ], [
                'name' => 'Fitness Training'
            ], [
                'name' => 'Yoga'
            ], [
                'name' => 'Cycling'
            ], [
                'name' => 'Water Sports'
            ], [
                'name' => 'Rock Climbing/Bouldering'
            ], [
                'name' => 'Snow Touring/Skiing'
            ], [
                'name' => 'Meta verse'
            ], [
                'name' => 'SALOMON products'
            ], [
                'name' => 'MONTBELL products'
            ], [
                'name' => 'GREGORY products'
            ], [
                'name' => 'CHUMS products'
            ], [
                'name' => 'HELINOX products'
            ], [
                'name' => 'MAMMUT products'
            ], [
                'name' => 'SNOW PEAK products'
            ], [
                'name' => 'HILLBERG products'
            ], [
                'name' => 'MSR products'
            ],
        ];
        foreach ($interests as $key => $value) {
            $interest = new Interests();
            $interest->name = $value['name'];
            $interest->save();
        }
    }
}