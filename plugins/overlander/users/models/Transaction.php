<?php

namespace Overlander\Users\Models;

use Model;

/**
 * Model
 */
class Transaction extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_users_transaction';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'member_no' => 'exists:overlander_users_users'
    ];
    public $customMessages = [
        'member_no' => 'The member number is not exist.'
    ];
}
