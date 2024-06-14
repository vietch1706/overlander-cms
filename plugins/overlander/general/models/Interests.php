<?php namespace Overlander\General\Models;

use Model;

/**
 * Model
 */
class Interests extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_general_interests';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

}
