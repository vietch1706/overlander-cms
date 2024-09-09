<?php

namespace Overlander\Transaction\models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Model
 */
class Transaction extends Model
{
    use Validation;

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_transaction_transaction';
    /**
     * @var array rules for validation.
     */
    public $rules = [
        'invoice_no' => 'required|unique:overlander_transaction_transaction,invoice_no'
    ];
    public $hasMany = [
        'detail' => [
            TransactionDetail::class,
            'key' => 'transaction_id'
        ]
    ];
    protected $jsonable = [
        'campaign',
    ];
}
