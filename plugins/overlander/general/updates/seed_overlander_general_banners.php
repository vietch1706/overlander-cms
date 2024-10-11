<?php

namespace Overlander\General\Updates;

use Carbon\Carbon;
use Overlander\General\Models\Banner;
use Overlander\General\Models\Brands;
use Seeder;
use function str_replace;

class SeedOverlanderGeneralBanners extends Seeder
{
    /**
     * run the database seeds.
     */
    public function run()
    {
        $banners = [
            [
                'name' => 'Whatsapp',
                'image' => '/banner/1.png',
                'link' => '',
                'published_at' => Carbon::now(),
                'expired_at' => Carbon::now()->addDays(30),
            ],
            [
                'name' => 'MSR',
                'image' => '/banner/2.jpg',
                'link' => 'https://www.hazelwoods.tw/pages/event',
                'published_at' => Carbon::now(),
                'expired_at' => Carbon::now()->addDays(30),
            ],
            [
                'name' => 'CHUMS',
                'image' => '/banner/3.jpg',
                'link' => 'https://chums.com/',
                'published_at' => Carbon::now(),
                'expired_at' => Carbon::now()->addDays(30),
            ],
            [
                'name' => 'CHUMS',
                'image' => '/banner/4.jpg',
                'link' => 'https://chums.com/',
                'published_at' => Carbon::now(),
                'expired_at' => Carbon::now()->addDays(30),
            ],
            [
                'name' => 'Gregory',
                'image' => '/banner/5.png',
                'link' => 'https://www.gregory.com/',
                'published_at' => Carbon::now(),
                'expired_at' => Carbon::now()->addDays(30),
            ],
            [
                'name' => 'CHUMS',
                'image' => '/banner/6.jpg',
                'link' => 'https://chums.com/',
                'published_at' => Carbon::now(),
                'expired_at' => Carbon::now()->addDays(30),
            ],
            [
                'name' => 'Gregory',
                'image' => '/banner/7.png',
                'link' => 'https://www.gregory.com/',
                'published_at' => Carbon::now(),
                'expired_at' => Carbon::now()->addDays(30),
            ],
            [
                'name' => 'Gregory',
                'image' => '/banner/8.jpg',
                'link' => '',
                'published_at' => Carbon::now(),
                'expired_at' => Carbon::now()->addDays(30),
            ],
            [
                'name' => 'Gregory',
                'image' => '/banner/9.png',
                'link' => 'https://www.gregory.com/',
                'published_at' => Carbon::now(),
                'expired_at' => Carbon::now()->addDays(30),
            ],
            [
                'name' => 'Pocari Sweat',
                'image' => '/banner/10.png',
                'link' => 'https://trypocari.com/',
                'published_at' => Carbon::now(),
                'expired_at' => Carbon::now()->addDays(30),
            ],
        ];
        foreach ($banners as $key => $value) {
            $banner = new Banner();
            $banner->name = $value['name'];
            $banner->image = $value['image'];
            $banner->link = $value['link'];
            $banner->published_at  = $value['published_at'];
            $banner->expired_at = $value['expired_at'];
//            $banner->created_at = Carbon::now();
//            $banner->updated_at = Carbon::now();
            $banner->save();
        }
    }
}
