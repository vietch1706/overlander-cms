<?php namespace Overlander\Users\Models;

use Model;

/**
 * Model
 */
class PointHistory extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_users_point_history';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

}
