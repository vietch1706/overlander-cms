<?php

namespace Overlander\General\Models;

use Model;

/**
 * Model
 */
class Stores extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var bool timestamps are disabled.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_general_stores';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'name' => 'required',
        'image' => 'required',
        'address' => 'required',
        'phone_number' => 'required|numeric|min:10|unique:overlander_general_stores',
        'start_hour' => 'required',
        'end_hour' => 'required',
    ];
}
