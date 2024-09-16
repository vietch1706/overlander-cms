<?php

namespace Overlander\General\Models;

use Model;
use Lang;
use Illuminate\Http\Request;

/**
 * Model
 */
class Contact extends Model
{
    use \October\Rain\Database\Traits\Validation;

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
            1 => 'Login Problems',
            2 => 'Points Porblems',
            3 => 'Others',
        ];
    }
}
