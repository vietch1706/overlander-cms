<?php

namespace Overlander\General\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Model
 */
class Brands extends Model
{
    use Validation;

    const CLOTHES = 0;
    const PICNIC_GEAR = 1;
    const POWER_FOOD = 2;
    const OUTDOOR_ACCESSORIES = 3;
    const KNIVES = 4;
    /**
     * @var bool timestamps are disabled.
     * Remove this line if timestamps are defined in the database table.
     */

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_general_brands';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'name' => 'required',
        'image' => 'required',
        'group' => 'required',
    ];

    public function getGroupOptions()
    {
        return [
            self::CLOTHES => 'Clothes',
            self::PICNIC_GEAR => 'Picnic Gear',
            self::POWER_FOOD => 'Power Food',
            self::OUTDOOR_ACCESSORIES => 'Outdoor Accessories',
            self::KNIVES => 'Knives'
        ];
    }


    public function beforeCreate()
    {
        $this->code = rand(200, 999);
    }

    public function scopeGetById($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeGetByName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function scopeGetByCode($query, $code)
    {
        return $query->where('code', $code);
    }
}
