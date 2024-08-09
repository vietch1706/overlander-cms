<?php

namespace Overlander\General\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Model
 */
class Contact extends Model
{
    use Validation;

    const LOGIN_PROBLEM = 1;
    const POINTS_PROBLEM = 2;
    const OTHERS_PROBLEM = 3;
    /**
     * @var bool timestamps are disabled.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;
    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_general_contact';

    /**
     * @var array rules for validation.
     */
    public $rules = [];

    public function getReasonOptions()
    {
        return [
            self::LOGIN_PROBLEM => 'Login Problems',
            self::POINTS_PROBLEM => 'Points Problems',
            self::OTHERS_PROBLEM => 'Others',
        ];
    }
}
