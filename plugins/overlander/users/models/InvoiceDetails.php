<?php namespace Overlander\Users\Models;

use Model;

/**
 * Model
 */
class InvoiceDetails extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_users_invoice_details';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'invoice_no' => 'required|exists:overlander_users_invoices:number'
    ];

}
