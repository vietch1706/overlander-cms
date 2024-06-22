<?php namespace Overlander\General\Models;

use Model;

/**
 * Model
 */
class VerificationQuestions extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_general_verification_questions';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

}
