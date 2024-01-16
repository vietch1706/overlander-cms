<?php namespace Overlander\General\Models;

use Model;

/**
 * Model
 */
class Supportivepage extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_general_supportivepage';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

}
