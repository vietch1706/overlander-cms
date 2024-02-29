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
        // 'longitude' => 'decimal',
        // 'latitude' => 'decimal',
        'shop_id' => 'required|unique:overlander_general_stores,shop_id',
        'phone_number' => ['required', 'unique:overlander_general_stores,phone_number', 'regex:/(84|0[3|5|7|8|9])+([0-9]{8})/', 'min_digits:10'],
        'start_hour' => 'required|before:end_hour',
        'end_hour' => 'required|after:start_hour',
    ];

    public $customMessages = [
        'phone_number.min_digits' => 'Phone number must have at least 10 number',
        'start_hour.before' => 'Start time must be before end time',
        'end_hour.before' => 'End time must be after start time',
    ];

    public function scopeGetById($query, $id)
    {
        return $query->where('id', $id);
    }
}
