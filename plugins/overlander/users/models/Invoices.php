<?php namespace Overlander\Users\Models;

use Model;
use Overlander\General\Models\Countries;

/**
 * Model
 */
class Invoices extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_users_invoices';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

    public $hasMany = [
        'number' => InvoiceDetails::class
    ];
}
