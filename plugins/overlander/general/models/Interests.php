<?php

namespace Overlander\General\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Model
 */
class Interests extends Model
{
    use Validation;

    /**
     * @var bool timestamps are disabled.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_general_interests';

    /**
     * @var array rules for validation.
     */
    public $rules = [];

    public static function getInterestName()
    {
        $interests = self::orderBy('name', 'asc')->get();
        $data = [];

        foreach ($interests as $interest) {
            $name = $interest->name ?? '';
            $data[$interest->id] = $name;
        }

        return $data;
    }

    public function scopeGetById($query, $id)
    {
        return $query->where('id', $id);
    }
}
