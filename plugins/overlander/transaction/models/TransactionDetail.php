<?php namespace Overlander\Transaction\Models;

use Model;

/**
 * Model
 */
class TransactionDetail extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_transaction_invoice_details';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

}
