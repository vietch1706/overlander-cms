<?php namespace Overlander\General\Models;

use Model;

/**
 * Model
 */
class Supportivepages extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_general_supportivepages';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'title' => 'required',
        'contents' => 'required',

    ];

}
