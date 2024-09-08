<?php namespace Overlander\Transaction\Models;

use Carbon\Carbon;
use Lang;
use Model;
use Overlander\Campaign\Models\Campaign;
use Overlander\General\Models\MembershipTier;
use Overlander\Users\Models\Users;

/**
 * Model
 */
class PointHistory extends Model
{
    use \October\Rain\Database\Traits\Validation;

    const GROUP_AUTOMATIC = 0;
    public const TYPE_GAIN = 0;
    public const TYPE_LOSS = 1;
    const EXPIRED_DATE_YEAR = 4;
    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_transaction_point_history';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

    public function afterCreate()
    {
        $user = Users::where('member_no', substr($this->member_no, 0, -1))->first();
        if (!empty($user)) {
            $user->points_sum += $this->amount;
            $user->save();
        }
    }

    public static function upgradeMembership()
    {
        $users = Users::where('is_activated', Users::ACTIVE)->where('role_id', Users::ROLE_CUSTOMER_ID)->get();
        foreach ($users as $key => $user) {
            $point = $user->points_sum;
            $membershipTiers = MembershipTier::where('group', self::GROUP_AUTOMATIC)->get();
            foreach ($membershipTiers as $key => $membershipTier) {
                if ($point > $membershipTier->points_required & $membershipTier->points_required != 0) {
                    switch ($membershipTier->slug) {
                        case MembershipTier::SLUG_ORDINARY:
                            $reason = Lang::get('overlander.transaction::lang.transaction.upgrade.ordinary');
                            break;
                        case MembershipTier::SLUG_VIP:
                            $reason = Lang::get('overlander.transaction::lang.transaction.upgrade.vip');
                            break;
                        case MembershipTier::SLUG_GOLD:
                            $reason = Lang::get('overlander.transaction::lang.transaction.upgrade.gold');
                            break;
                        default:
                            $reason = '';
                            break;
                    };
                    $pointHistory = new PointHistory();
                    $pointHistory->member_no = $user->member_no . $user->member_prefix;
                    $pointHistory->type = PointHistory::TYPE_LOSS;
                    $pointHistory->amount = $membershipTier->points_remain;
                    $pointHistory->reason = $reason;
                    $pointHistory->expired_date = null;
                    $pointHistory->save();

                    $user->points_sum = $user->points_sum - $membershipTier->points_remain;
                    $user->membership_tier_id = $membershipTier->id;
                    $user->join_date = Carbon::now();
                    $user->validity_date = Carbon::now()->addMonth($membershipTier->period);
                    $user->save();

                }
            }
        }
    }

    public static function pointMultiplier($transactionDetail, $transaction)
    {
        $campaign = Campaign::where('status', Campaign::STATUS_ACTIVATE)->get();
        foreach ($campaign as $key => $campaignItem) {
            if ($transaction->date->between($campaignItem->start_date, $campaignItem->end_date)) {
                
            }
        }
        return;
    }
}
