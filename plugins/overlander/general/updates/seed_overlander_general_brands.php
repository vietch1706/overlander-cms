<?php

namespace Overlander\General\Updates;

use Carbon\Carbon;
use Overlander\General\Models\Brands;
use Seeder;

/**
 * BrandsSeeders
 */
class seed_overlander_general_brands extends Seeder
{
    /**
     * run the database seeds.
     */
    public function run()
    {
        $brands = [
            [
                'name' => 'MontBell',
                'description' => '<p>MontBell has been developing outdoor products that follow the Japanese tradition of kinobi：Function is Beauty. The history of MontBell parallels the evolution of our functional and beautiful outdoor products.</p>',
                'group' => Brands::CLOTHES,
            ],
            [
                'name' => 'Gregory',
                'description' => '<p>From the earliest days, Gregory packs were noted for innovative design, ergonomic and comfortable fit, and our obsession with quality, comfort and durability continues today.</p>',
                'group' => Brands::CLOTHES,
            ],
            [
                'name' => 'CHUMS',
                'description' => '<p>CHUMS has been popular with Japanese youngsters and outdoor lovers. With its quality clothing and gear, it is like on vacation every day with the fun and colorful look of the CHUMS style.</p>',
                'group' => Brands::CLOTHES,
            ],
            [
                'name' => 'Salomon',
                'description' => '<p>Founded in 1947 in the heart of the French Alps. Since then, Salomon has been developing a vast range of revolutionary new concepts for skiing and brought innovative solutions to footwear, apparel and equipment for many mountain sports to enhance the performance of athletes.</p>',
                'group' => Brands::CLOTHES,
            ],
            [
                'name' => 'Mammut',
                'description' => '',
                'group' => Brands::CLOTHES,
            ],
            [
                'name' => 'Millet',
                'description' => '<p>Millet has for over 60 years been supporting mountaineers’ Alpine and Himalayan summit achievements.</p>',
                'group' => Brands::CLOTHES,
            ],
            [
                'name' => 'WPC/KIU',
                'description' => '',
                'group' => Brands::CLOTHES,
            ],
            [
                'name' => 'Deuter',
                'description' => '<p>Deuter packs are designed with a wealth of experience and innovative creativity, always keeping our consumer\'s comfort and satisfaction in mind.</p>',
                'group' => Brands::CLOTHES,
            ],
            [
                'name' => 'Outdoor Research',
                'description' => '<p>Based in Seattle since 1981, they are committed to improving their customer’s experience through innovative materials, purpose-driven features, and versatile products that are backed by their Infinite Guarantee.</p>',
                'group' => Brands::CLOTHES,
            ],
            [
                'name' => 'Helinox',
                'description' => '',
                'group' => Brands::CLOTHES,
            ],
            [
                'name' => 'Kovea',
                'description' => '<p>Since the establishment in 1982, Kovea has contributed to the creation and expansion of outdoor and camping culture throughout the world. Kovea stands for top rated customer satisfaction, superior quality and development of new innovative products. Kovea is working to go “Beyond the Limits” to make an outdoor experience one to remember.</p>',
                'group' => Brands::CLOTHES,
            ],
            [
                'name' => 'Snow Peak',
                'description' => '<p>Snow Peak provides a wide range of high-quality outdoor products to discerning consumers worldwide.</p>',
                'group' => Brands::CLOTHES,
            ],
            [
                'name' => 'Hilleberg',
                'description' => '<p>Found in 1971, Hilleberg, the Swedish tent maker, made its first tent that offered simultaneous pitching of the inner and outer tent soon afterwards. Since then Hilleberg aims to be the best tentmaker rather than the biggest one in the market-place.</p>',
                'group' => Brands::PICNIC_GEAR,
            ],
            [
                'name' => 'Therm-A-Rest',
                'description' => '<p>Invented in 1971 by founders of Cascade Designs, the revolutionary self-inflating Therm-A-Rest; mattress allows mountain climbers and outdoor enthusiasts to sleep better in warmth and comfort all night long.</p>',
                'group' => Brands::PICNIC_GEAR,
            ],
            [
                'name' => 'MSR',
                'description' => '<p>In 1969, Seattle engineer and lifelong mountaineer Larry Penberthy formed Mountain Safety Research as a one-man crusade dedicated to improving the safety of climbing equipment. The fuel behind Larry\'s passionate fire was a simple belief that still drives our team today: The idea that better, safer, more reliable equipment is the key to unlocking greater adventures. Today, many MSR products are still hand-built on manufacturing lines just a floor below where we concept them.</p>',
                'group' => Brands::PICNIC_GEAR,
            ],
            [
                'name' => 'Wind x-treme',
                'description' => '',
                'group' => Brands::PICNIC_GEAR,
            ],
            [
                'name' => 'CAPTAIN STAG',
                'description' => '',
                'group' => Brands::PICNIC_GEAR,
            ],
            [
                'name' => 'Pack Towl',
                'description' => '',
                'group' => Brands::PICNIC_GEAR,
            ],
            [
                'name' => 'N-Rit',
                'description' => '<p>The N-rit brand represents the natural spirit as combination of nature and spirit, and harmony that human beings live with nature learning the greatness of nature. Naschem starting from 1983 will do its best to reward with the best quality so that it can remain forever in everyone\'s heart as a partner of the outdoor life and as a leader of the world.</p>',
                'group' => Brands::PICNIC_GEAR,
            ],
            [
                'name' => 'AKU',
                'description' => '<p>Italian trekking and outdoor footwear. Today AKU is considered one of Europe\'s leading brands in the outdoor market. AKU has for 90% of its shoes the exclusive outsoles designed together with Vibram for both the specific design and shape of the outsole.</p>',
                'group' => Brands::PICNIC_GEAR,
            ],
            [
                'name' => 'Platypus',
                'description' => '<p>Platypus hydration puts the finest, taste-free systems at your fingertips so you can savor the end of your day as much as the beginning. To ensure it, Platypus has spent thousands of hours putting new films and technologies through rigorous testing and miles of field use.</p>',
                'group' => Brands::PICNIC_GEAR,
            ],
            [
                'name' => 'SealLine',
                'description' => '<p>SealLine has been building gear protection that way since 1985 and continue to stand behind a warranty that second to none. When you need to rely on your gear to accomplish your goals, you can rely on SealLine to get the job done.</p>',
                'group' => Brands::PICNIC_GEAR,
            ],
            [
                'name' => 'Evernew',
                'description' => '<p>Evernew is the largest manufacturer of outdoors,mountaineering, camping equipment, plus the leading manufacturer of titanium cookware.</p>',
                'group' => Brands::PICNIC_GEAR,
            ],
            [
                'name' => 'Power Bar',
                'description' => '',
                'group' => Brands::POWER_FOOD,
            ],
            [
                'name' => 'Gu',
                'description' => '',
                'group' => Brands::POWER_FOOD,
            ],
            [
                'name' => 'OVERSTIMS',
                'description' => '',
                'group' => Brands::POWER_FOOD,
            ],
            [
                'name' => 'CLIF',
                'description' => '',
                'group' => Brands::POWER_FOOD,
            ],
            [
                'name' => 'Pocari',
                'description' => '',
                'group' => Brands::POWER_FOOD,
            ],
            [
                'name' => 'TAILWIND',
                'description' => '',
                'group' => Brands::POWER_FOOD,
            ],
            [
                'name' => 'Hammer',
                'description' => '',
                'group' => Brands::POWER_FOOD,
            ],
            [
                'name' => 'Weider',
                'description' => '',
                'group' => Brands::POWER_FOOD,
            ],
            [
                'name' => 'Fruit to go',
                'description' => '',
                'group' => Brands::POWER_FOOD,
            ],
            [
                'name' => 'Natures Baker',
                'description' => '',
                'group' => Brands::POWER_FOOD,
            ],
            [
                'name' => 'Backpackers pantry',
                'description' => '',
                'group' => Brands::POWER_FOOD,
            ],
            [
                'name' => 'AT CHEF',
                'description' => '',
                'group' => Brands::POWER_FOOD,
            ],
            [
                'name' => 'Trangia',
                'description' => '',
                'group' => Brands::OUTDOOR_ACCESSORIES,
            ],
            [
                'name' => 'Liberty Mountain',
                'description' => '',
                'group' => Brands::OUTDOOR_ACCESSORIES,
            ],
            [
                'name' => 'CANCER COUNCIL',
                'description' => '',
                'group' => Brands::OUTDOOR_ACCESSORIES,
            ],
            [
                'name' => 'PARA KITO',
                'description' => '',
                'group' => Brands::OUTDOOR_ACCESSORIES,
            ],
            [
                'name' => 'Rumble Roller',
                'description' => '',
                'group' => Brands::OUTDOOR_ACCESSORIES,
            ],
            [
                'name' => 'PARZT',
                'description' => '',
                'group' => Brands::OUTDOOR_ACCESSORIES,
            ],
            [
                'name' => 'Vargo',
                'description' => '',
                'group' => Brands::OUTDOOR_ACCESSORIES,
            ],
            [
                'name' => 'OUTSIDE INSIDE',
                'description' => '',
                'group' => Brands::OUTDOOR_ACCESSORIES,
            ],
            [
                'name' => 'PARZT',
                'description' => '',
                'group' => Brands::OUTDOOR_ACCESSORIES,
            ],
            [
                'name' => 'Vargo',
                'description' => '',
                'group' => Brands::OUTDOOR_ACCESSORIES,
            ],
            [
                'name' => 'OUTSIDE INSIDE',
                'description' => '',
                'group' => Brands::OUTDOOR_ACCESSORIES,
            ],
            [
                'name' => 'Damascus',
                'description' => '',
                'group' => Brands::KNIVES,
            ],
            [
                'name' => 'OPINEL',
                'description' => '',
                'group' => Brands::KNIVES,
            ],
            [
                'name' => 'LANSKY SHARPENERS',
                'description' => '',
                'group' => Brands::KNIVES,
            ],
            [
                'name' => 'Bear & Son Cutlery',
                'description' => '',
                'group' => Brands::KNIVES,
            ],
            [
                'name' => 'Browning',
                'description' => '',
                'group' => Brands::KNIVES,
            ],
            [
                'name' => 'Buck',
                'description' => '',
                'group' => Brands::KNIVES,
            ],
            [
                'name' => 'MARBLES',
                'description' => '',
                'group' => Brands::KNIVES,
            ],
        ];
        foreach ($brands as $key => $value) {
            $brand = new Brands();
            $brand->name = $value['name'];
            $brand->group = $value['group'];
            $value['name'] = str_replace('/', '', $value['name']);
            $brand->description = $value['description'];
            $brand->image = '/brands/' . $value['name'] . '.png';
            $brand->created_at = Carbon::now();
            $brand->updated_at = Carbon::now();
            $brand->save();
        }
    }
}
