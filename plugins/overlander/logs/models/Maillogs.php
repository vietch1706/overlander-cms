<?php namespace Overlander\Logs\Models;

use Model;

/**
 * Model
 */
class Maillogs extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_logs_maillogs';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'email' => 'required|email',
        'content' => 'required',
        'method' => 'required'
    ];

}
