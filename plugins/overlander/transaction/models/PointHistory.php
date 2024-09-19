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

    public const IS_USED_USABLE = 0;
    public const IS_USED_UNUSABLE = 1;
    public const IS_HALTED_TRUE = 1;
    public const IS_HALTED_FALSE = 0;
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

    public static function gradeDailyCheck($user, $currentMembership, $reason)
    {
        if ($user->points_sum >= $currentMembership->points_remain) {
            $currentPoint = match ($currentMembership->slug) {
                MembershipTier::SLUG_GOLD => Users::DEFAULT_POINTS_SUM,
                default => $user->points_sum - $currentMembership->points_remain,
            };
            $preparePointHistory = [
                'member_no' => $user->member_no . $user->member_prefix,
                'type' => self::TYPE_LOSS,
                'amount' => match ($currentMembership->slug) {
                    MembershipTier::SLUG_GOLD => $user->points_sum,
                    default => $currentMembership->points_remain,
                },
                'transaction_id' => null,
                'reason' => $reason,
                'expired_date' => null,
            ];
            self::addPointHistory($preparePointHistory);

            $user->points_sum = $currentPoint;
            $user->membership_tier_id = $currentMembership->id;
            $user->validity_date = Carbon::now()->addMonth($currentMembership->period);
            $user->save();
        } else {
            $previousMembership = MembershipTier::getPreviousMembership($currentMembership->id);
            if (!empty($previousMembership)) {
                $user->membership_tier_id = $previousMembership->id;
                $user->validity_date = Carbon::now()->addMonth($previousMembership->period);
                $user->save();
            }
        }
    }

    public function getTypeOptions()
    {
        return [
            self::TYPE_GAIN => 'Point Gain',
            self::TYPE_LOSS => 'Point Loss',
        ];
    }


    public static function upgradeMembership()
    {
        $users = Users::where('status', Users::STATUS_ACTIVE)
            ->where('is_activated', Users::STATUS_ACTIVE)
            ->where('role_id', Users::ROLE_CUSTOMER_ID)
            ->get();
        foreach ($users as $key => $user) {
            $point = $user->points_sum;
            $membershipTier = MembershipTier::select('id', 'name', 'slug', 'points_required', 'period')
                ->where('group', MembershipTier::GROUP_AUTOMATIC)
                ->whereNot('slug', MembershipTier::SLUG_TEMPORARY)
                ->whereNot('id', $user->membership_tier_id)
                ->where('id', '>', $user->membership_tier_id)
                ->where('points_required', '<=', $point)
                ->orderBy('id', 'desc')
                ->first();
            if (empty($membershipTier)) {
                continue;
            }
            $pointHistory = [
                'member_no' => $user->member_no . $user->member_prefix,
                'type' => self::TYPE_LOSS,
                'amount' => $membershipTier->points_required,
                'transaction_id' => null,
                'reason' => Lang::get('overlander.transaction::lang.transaction.upgrade', ['membership' => $membershipTier->name]),
                'expired_date' => null,
            ];
            self::addPointHistory($pointHistory);
            if ($membershipTier->slug == MembershipTier::SLUG_GOLD) {
                $user->points_sum = Users::DEFAULT_POINTS_SUM;
//                self::checkPointExpiredDate(Users::DEFAULT_POINTS_SUM, $user->member_no . $user->member_prefix);
            } else {
                $user->points_sum = $user->points_sum - $membershipTier->points_required;
//                self::checkPointExpiredDate($membershipTier->points_required, $user->member_no . $user->member_prefix);
            }

            $user->membership_tier_id = $membershipTier->id;
            $user->join_date = Carbon::now();
            $user->validity_date = Carbon::now()->addMonth($membershipTier->period);
            $user->save();
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
                    ->where('brand_id', $transactionDetail->brand_code)
                    ->first();
                $skuCampaign = self::getCampaign(Campaign::TARGET_SKU)
                    ->where('sku', $transactionDetail->plc)
                    ->first();

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

            $user = Users::select('membership_tier_id')
                ->where(DB::raw('concat(member_no, member_prefix)'), $transaction->vip)
                ->first();

            $membershipCampaign = self::getCampaign(Campaign::TARGET_MEMBERSHIP)
                ->where('membership_tier_id', $user->membership_tier_id)
                ->first();
            $shopCampaign = self::getCampaign(Campaign::TARGET_SHOP)
                ->where('shop', $transaction->shop_id)
                ->first();

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

            $totalPoint = TransactionDetail::where('transaction_id', $transaction->id)
                    ->sum('point') * $pointMultiplier;

            $pointHistory = [
                'member_no' => $transaction->vip,
                'type' => $totalPoint > 0 ? self::TYPE_GAIN : self::TYPE_LOSS,
                'amount' => $totalPoint,
                'transaction_id' => $transaction->id,
                'reason' => Lang::get('overlander.transaction::lang.point_history.gain_reason.invoice', ['invoice_no' => $transaction->invoice_no]),
                'expired_date' => Carbon::now()->addYear(self::EXPIRED_DATE_YEAR),
            ];
            self::addPointHistory($pointHistory);
            $transaction->is_checked = Transaction::IS_CHECKED_CHECK;
            $transaction->campaign = array_filter($campaignUsed);;
            $transaction->save();
        }
    }

    /**
     * Class Constructor.
     * @param array $pointHistory = [
     *      'member_no' => (string) Member Number. Required.
     *      'type' => (boolean) Point History Type. Required.
     *      'amount' => (double) Point Used Amount. Required.
     *      'transaction_id' => (int) Transaction.
     *      'Reason' => (string) History Reason. Required.
     *      'expired_date' => (datetime) History Date.
     * ]
     * @return void
     */
    public static function addPointHistory(array $pointHistory): void
    {
        $history = new self();
        $history->member_no = $pointHistory['member_no'];
        $history->type = $pointHistory['type'];
        $history->amount = $pointHistory['amount'];
        $history->transaction_id = $pointHistory['transaction_id'];
        $history->reason = $pointHistory['reason'];
        $history->expired_date = $pointHistory['expired_date'];
        $history->save();
    }

    public static function updateHiddenPoint($point, $userMemberNo, $currentMembership)
    {
        if ($currentMembership->slug == MembershipTier::SLUG_GOLD) {
            $updatePointHistory = self::where('member_no', $userMemberNo)
                ->where('type', self::TYPE_GAIN)
                ->update(
                    [
                        'is_halted' => self::IS_HALTED_TRUE,
                        'is_used' => self::IS_USED_UNUSABLE,
                    ]
                );
            return;
        }
        #TODO: sua lai cot is_hidden (su dung cho api va backend), cot is_used (su dung query tinh diem)
        $pointHistory = self::where('member_no', $userMemberNo)
            ->where('type', self::TYPE_GAIN)
            ->where('is_used', self::IS_USED_USABLE)
            ->where('is_halted', self::IS_HALTED_FALSE)
            ->orderBy('expired_date', 'asc')
            ->get();
        foreach ($pointHistory as $key => $history) {
            if ($point >= $history->amount) {
                $point -= $history->amount;
                $history->is_halted = self::IS_HALTED_TRUE;
                $history->is_used = self::IS_USED_UNUSABLE;
                $history->save();
            } else {
                $newPoint = $history->amount - $point;
                $invoiceNo = substr($history->reason, strpos($history->reason, ':') + 1);
                $preparePointHistory = [
                    'member_no' => $history->member_no,
                    'type' => self::TYPE_GAIN,
                    'amount' => $newPoint,
                    'transaction_id' => $history->transaction_id,
                    'reason' => Lang::get('overlander.transaction::lang.point_history.gain_reason.remain', ['invoice_no' => $invoiceNo]),
                    'expired_date' => $history->expired_date,
                ];
                self::addPointHistory($preparePointHistory);
                $history->is_halted = self::IS_HALTED_TRUE;
                $history->save();
                break;
            }

        }
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
        if (!empty($user) && $this->type == self::TYPE_GAIN) {
            $user->points_sum += $this->amount;
            $user->save();
        }
    }
}
