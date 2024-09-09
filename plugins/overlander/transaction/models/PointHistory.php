<?php namespace Overlander\Transaction\models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lang;
use Model;
use October\Rain\Database\Traits\Validation;
use Overlander\Campaign\Models\Campaign;
use Overlander\General\Models\MembershipTier;
use Overlander\Users\Models\Users;

/**
 * Model
 */
class PointHistory extends Model
{
    use Validation;

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
                    }
                    if ($user->membership_tier_id != $membershipTier->id) {
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
    }

    public static function pointMultiplier($transactionDetail, $transaction)
    {
        $campaign = Campaign::where('status', Campaign::STATUS_ACTIVATE)->get();
        $transactionDate = Carbon::create($transaction->date);
        $pointMultiplier = 0;
        $membershipCampaign = $campaign->where('target', Campaign::TARGET_MEMBERSHIP)->max('multiplier')->first();
        $shopCampaign = $campaign->where('target', Campaign::TARGET_SHOP)->max('multiplier')->first();
        $brandCampaign = $campaign->where('target', Campaign::TARGET_BRAND)->max('multiplier')->first();
        $skuCampaign = $campaign->where('target', Campaign::TARGET_SKU)->max('multiplier')->first();
        $user = Users::where(DB::raw('concat(member_no, member_prefix)'), $transaction->vip)->first();
        if (
            $transactionDate->between($membershipCampaign->start_date, $membershipCampaign->end_date) &&
            $user->membership_tier_id == $membershipCampaign->membership_tier_id
        ) {
            $pointMultiplier += $membershipCampaign->multiplier;
            $transaction->campaign = json_encode($membershipCampaign);
            $transaction->save();
        }
        if (
            $transactionDate->between($shopCampaign->start_date, $shopCampaign->end_date)
            &&
            $transaction->shop_id == $shopCampaign->shop
        ) {
            $pointMultiplier += $shopCampaign->multiplier;
            $transaction->campaign = json_encode($shopCampaign);
            $transaction->save();

        }
        if (
            $transactionDate->between($brandCampaign->start_date, $brandCampaign->end_date)
            &&
            $transactionDetail->brand_code == $brandCampaign->brand_id
        ) {
            $pointMultiplier += $brandCampaign->multiplier;
            $transaction->campaign = json_encode($brandCampaign);
            $transaction->save();
        }
        if (
            $transactionDate->between($skuCampaign->start_date, $skuCampaign->end_date)
            &&
            $transactionDetail->brand_code == $skuCampaign->brand_id
        ) {
            $pointMultiplier += $skuCampaign->multiplier;
            $transaction->campaign = json_encode($skuCampaign);
            $transaction->save();
        }
        if ($pointMultiplier != 0) {
            $transaction->save();
            return $pointMultiplier;
        }
        return Campaign::DEFAULT_POINT_MULTIPLIER;
    }

    public function afterCreate()
    {
        $user = Users::where('member_no', substr($this->member_no, 0, -1))->first();
        if (!empty($user)) {
            $user->points_sum += $this->amount;
            $user->save();
        }
    }
}
