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

    public $table = 'overlander_general_stores';
    /**
     * @var string table in the database used by the model.
     */
    /**
     * @var array rules for validation.
     */
    public $rules = [
        'name' => 'required',
        'image' => 'required',
        'address' => 'required',
        'longitude' => 'decimal',
        'latitude' => 'decimal',
        'shop_id' => 'required|unique:overlander_general_stores,shop_id',
        'phone_number' => 'numeric|required|unique:overlander_general_stores,phone_number|digits_between:7,15',
        'start_hour' => 'required|before:end_hour',
        'end_hour' => 'required|after:start_hour',
    ];

    public $customMessages = [
        'phone_number.digits_between' => 'Phone number must be from 7 to 15 numbers',
        'start_hour.before' => 'Start time must be before end time',
        'end_hour.before' => 'End time must be after start time',
    ];
}
