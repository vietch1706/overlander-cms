<?php namespace Overlander\Transaction\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Model;
use October\Rain\Database\Traits\Validation;
use Overlander\Users\Models\Users;

/**
 * Model
 */
class TransactionDetail extends Model
{
    use Validation;
    public const DEFAULT_POINT_VALUE = 0;

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_transaction_transaction_details';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

}
