<?php namespace Overlander\Transaction\models;

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


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_transaction_invoice_details';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

    public static function testFunction()
    {

    }

    public function afterCreate()
    {
        $transaction = Transaction::where('id', $this->transaction_id)->first();
        $user = Users::where(DB::raw('concat(member_no, member_prefix)'), $transaction->vip)->first();
        if (!empty($user)) {
            $pointHistory = new PointHistory();
            $pointHistory->member_no = $transaction->vip;
            $pointHistory->type = $this->quantity < 0 ? PointHistory::TYPE_GAIN : PointHistory::TYPE_LOSS;
            $pointMultiplier = PointHistory::pointMultiplier($this, $transaction);
            $pointHistory->amount = $this->fprice * $pointMultiplier;
            $pointHistory->reason = $this->description;
            $pointHistory->expired_date = Carbon::create($transaction->date)->addYear(PointHistory::EXPIRED_DATE_YEAR);
            $pointHistory->created_at = Carbon::now();
            $pointHistory->updated_at = Carbon::now();
            $pointHistory->save();
        }
    }
}
