<?php

namespace Overlander\General\Models;

use Model;

/**
 * Model
 */
class Countries extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_general_countries';

    /**
     * @var array rules for validation.
     */
    public $rules = [];
}
