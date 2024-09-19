<?php

namespace Overlander\Transaction\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Model
 */
class Transaction extends Model
{
    use Validation;

    public const IS_CHECKED_CHECK = 1;
    public const IS_CHECKED_UNCHECK = 0;

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
    public $hasOne = [
        'point_history' => [
            PointHistory::class,
            'key' => 'transaction_id'
        ]
    ];

    protected $jsonable = [
        'campaign',

    ];

    public function getPointHistoryPreview($id)
    {
        return PointHistory::where('is_halted', PointHistory::IS_HALTED_FALSE)
            ->where('is_used', PointHistory::IS_USED_USABLE)
            ->where('transaction_id', $id)->first()->id;
    }
    public function getTotalPointAttribute()
    {
        return PointHistory::select('amount')
            ->where('is_halted', PointHistory::IS_HALTED_FALSE)
            ->where('is_used', PointHistory::IS_USED_USABLE)
            ->where('transaction_id', $this->id)->get()->sum('amount');
    }
}
