<?php

namespace Overlander\General\Models;

use Model;

/**
 * Model
 */
class Background extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_general_background';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'name' => 'required',
        'splash_screen' => 'required',
        'publish_date' => 'required|before:end_date',
        'end_date' => 'required|after:tomorrow',
    ];
}
