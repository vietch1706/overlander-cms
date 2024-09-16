<?php namespace Overlander\Transaction\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lang;
use Model;
use October\Rain\Database\Traits\Validation;
use Overlander\Campaign\Models\Campaign;
use Overlander\General\Models\MembershipTier;
use Overlander\Users\Models\Users;
use stdClass;

/**
 * Model
 */
class PointHistory extends Model
{
    use Validation;

    public const DEFAULT_POINT_MULTIPLIER = 1;
    public const POINT_MULTIPLIER_COUNTER = 0;
    public const TYPE_GAIN = 0;
    public const TYPE_LOSS = 1;
    public const EXPIRED_DATE_YEAR = 4;
    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_transaction_point_history';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

    public function getTypeOptions()
    {
        return [
            self::TYPE_GAIN => 'Point Gain',
            self::TYPE_LOSS => 'Point Loss',
        ];
    }

    public function getPointHistory($id)
    {
        return $this->where('transaction_id', $id)->first()->id;
    }


    public static function upgradeMembership()
    {
        $users = Users::where('status', Users::STATUS_ACTIVE)
            ->where('is_activated', Users::STATUS_ACTIVE)
            ->where('role_id', Users::ROLE_CUSTOMER_ID)->get();
        foreach ($users as $key => $user) {
            $point = $user->points_sum;
            $membershipTiers = MembershipTier::where('group', MembershipTier::GROUP_AUTOMATIC)->get();
            foreach ($membershipTiers as $key => $membershipTier) {
                if (
                    $point > $membershipTier->points_required &&
                    $membershipTier->points_required != 0 &&
                    $user->membership_tier_id != $membershipTier->id
                ) {
                    $reason = match ($membershipTier->slug) {
                        MembershipTier::SLUG_ORDINARY => Lang::get('overlander.transaction::lang.transaction.upgrade', ['membership' => $membershipTier->name]),
                        MembershipTier::SLUG_VIP => Lang::get('overlander.transaction::lang.transaction.upgrade', ['membership' => $membershipTier->name]),
                        MembershipTier::SLUG_GOLD => Lang::get('overlander.transaction::lang.transaction.upgrade', ['membership' => $membershipTier->name]),
                        default => '',
                    };

                    $pointHistory = new PointHistory();
                    $pointHistory->member_no = $user->member_no . $user->member_prefix;
                    $pointHistory->type = self::TYPE_LOSS;
                    $pointHistory->amount = $membershipTier->points_remain;
                    $pointHistory->reason = $reason;
                    $pointHistory->expired_date = null;
                    $pointHistory->save();

                    if ($membershipTier->slug == MembershipTier::SLUG_GOLD) {
                        $user->points_sum = 0;
                    } else {
                        $user->points_sum = $user->points_sum - $membershipTier->points_remain;
                    }

                    $user->membership_tier_id = $membershipTier->id;
                    $user->join_date = Carbon::now();
                    $user->validity_date = Carbon::now()->addMonth($membershipTier->period);
                    $user->save();
                }
            }
        }
    }

    public static function calculatePointMultiplier($transactionDate, $campaign, $currentMultiplier): array
    {
        $objCampaign = new stdClass();
        #TODO: check if current point multiplier is default or not
        $currentMultiplier = $currentMultiplier === self::DEFAULT_POINT_MULTIPLIER ? self::POINT_MULTIPLIER_COUNTER : $currentMultiplier;
        $transactionDate = Carbon::create($transactionDate);
        if (
            $transactionDate->between($campaign->start_date, $campaign->end_date)
        ) {
            $currentMultiplier += $campaign->multiplier;
            $objCampaign->id = $campaign->id;
            $objCampaign->multiplier = $campaign->multiplier;
        } else {
            return match ($currentMultiplier) {
                0 => [
                    'point_multiplier' => self::DEFAULT_POINT_MULTIPLIER,
                    'campaign_used' => null,
                ],
                default => [
                    'point_multiplier' => $currentMultiplier,
                    'campaign_used' => null,
                ],
            };
        }
        return match ($currentMultiplier) {
            0 => [
                'point_multiplier' => self::DEFAULT_POINT_MULTIPLIER,
                'campaign_used' => $objCampaign,
            ],
            default => [
                'point_multiplier' => $currentMultiplier,
                'campaign_used' => $objCampaign,
            ],
        };
    }

    public static function calculatePoint(): void
    {
        $transactions = Transaction::where('is_checked', Transaction::IS_CHECKED_UNCHECK)->get();
        foreach ($transactions as $key => $transaction) {
            foreach ($transaction->detail as $key => $transactionDetail) {

                $pointMultiplier = self::POINT_MULTIPLIER_COUNTER;
                $campaignUsed = [];
                $brandCampaign = self::getCampaign(Campaign::TARGET_BRAND)
                    ->where('brand_id', $transactionDetail->brand_code)->first();
                $skuCampaign = self::getCampaign(Campaign::TARGET_SKU)
                    ->where('sku', $transactionDetail->plc)->first();

                if (!empty($brandCampaign) && $brandCampaign->brand_id == $transactionDetail->brand_code) {
                    $pointArray = self::calculatePointMultiplier($transaction->date, $brandCampaign, $pointMultiplier);
                    $campaignUsed['brand_campaign'] = $pointArray['campaign_used'];
                    $pointMultiplier = $pointArray['point_multiplier'];
                }

                if (!empty($skuCampaign) && $skuCampaign->sku == $transactionDetail->plc) {
                    $pointArray = self::calculatePointMultiplier($transaction->date, $skuCampaign, $pointMultiplier);
                    $campaignUsed['sku_campaign'] = $pointArray['campaign_used'];
                    $pointMultiplier = $pointArray['point_multiplier'];
                }

                if (empty($campaignUsed) || $transactionDetail->quantity < 0) {
                    $pointMultiplier = self::DEFAULT_POINT_MULTIPLIER;
                }

                $transactionDetail->point = $transactionDetail->fprice * $pointMultiplier;
                $transactionDetail->campaign = array_filter($campaignUsed);
                $transactionDetail->save();
            }
            #TODO: reset point multiplier for transaction campaign, and reset campaign used
            $pointMultiplier = self::POINT_MULTIPLIER_COUNTER;
            $campaignUsed = [];

            $user = Users::where(DB::raw('concat(member_no, member_prefix)'), $transaction->vip)->first();

            $membershipCampaign = self::getCampaign(Campaign::TARGET_MEMBERSHIP)
                ->where('membership_tier_id', $user->membership_tier_id)->first();
            $shopCampaign = self::getCampaign(Campaign::TARGET_SHOP)
                ->where('shop', $transaction->shop_id)->first();

            if (!empty($membershipCampaign) && $membershipCampaign->membership_tier_id == $user->membership_tier_id) {
                $pointArray = self::calculatePointMultiplier($transaction->date, $membershipCampaign, $pointMultiplier);
                $pointMultiplier = $pointArray['point_multiplier'];
                $campaignUsed['membership_campaign'] = $pointArray['campaign_used'];
            }

            if (!empty($shopCampaign) && $shopCampaign->shop == $transaction->shop_id) {
                $pointArray = self::calculatePointMultiplier($transaction->date, $shopCampaign, $pointMultiplier);
                $pointMultiplier = $pointArray['point_multiplier'];
                $campaignUsed['shop_campaign'] = $pointArray['campaign_used'];
            }

            if (empty($campaignUsed)) {
                $pointMultiplier = self::DEFAULT_POINT_MULTIPLIER;
            }

            $totalPoint = TransactionDetail::where('transaction_id', $transaction->id)->sum('point') * $pointMultiplier;

//            $pointHistory = new PointHistory();
//            $pointHistory->member_no = $transaction->vip;
//            $pointHistory->type = $totalPoint < 0 ? self::TYPE_LOSS : self::TYPE_GAIN;
//            $pointHistory->amount = $totalPoint;
//            $pointHistory->transaction_id = $transaction->id;
//            $pointHistory->reason = Lang::get('overlander.transaction::lang.point_history.gain_reason.invoice', ['invoice_no' => $transaction->invoice_no]);
//            $pointHistory->expired_date = Carbon::now()->addYear(self::EXPIRED_DATE_YEAR);
//            $pointHistory->save();
            $reason = Lang::get('overlander.transaction::lang.point_history.gain_reason.invoice', ['invoice_no' => $transaction->invoice_no]);
            self::addPointHistory($transaction->vip, $totalPoint, $transaction->id, $reason);
            $transaction->is_checked = Transaction::IS_CHECKED_CHECK;
            $transaction->campaign = array_filter($campaignUsed);;
            $transaction->save();
        }
    }

    public static function addPointHistory($member_no, $points, $transaction_id, $reason)
    {
        $pointHistory = new PointHistory();
        $pointHistory->member_no = $member_no;
        $pointHistory->type = $points < 0 ? self::TYPE_LOSS : self::TYPE_GAIN;
        $pointHistory->amount = $points;
        $pointHistory->transaction_id = $transaction_id;
        $pointHistory->reason = $reason;
        $pointHistory->expired_date = Carbon::now()->addYear(self::EXPIRED_DATE_YEAR);
        $pointHistory->save();

    }

    public static function getCampaign($target)
    {
        return Campaign::where('status', Campaign::STATUS_ACTIVATE)
            ->where('target', $target)
            ->orderBy('multiplier', 'desc');
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
