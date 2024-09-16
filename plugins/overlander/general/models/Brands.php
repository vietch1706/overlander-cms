<?php

namespace Overlander\General\Models;

use Model;

/**
 * Model
 */
class Brands extends Model
{
    use \October\Rain\Database\Traits\Validation;

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
    ];

    public function scopeGetById($query, $id)
    {
        return $query->where('id', $id)->first();
    }
}
