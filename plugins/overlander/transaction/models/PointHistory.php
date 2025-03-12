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
    public const IS_HIDDEN_TRUE = 1;
    public const IS_HIDDEN_FALSE = 0;
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

    public $fillable = [
        'is_used',
        'is_hidden',
    ];
    public $hasOne = [
        'transaction' => [
            Transaction::class,
            'key' => 'id'
        ]
    ];

    public static function membershipTierCheck($user, $currentMembership, $reason)
    {
        if ($user->points_sum >= $currentMembership->points_remain) {
            $currentPoint = match ($currentMembership->slug) {
                MembershipTier::SLUG_GOLD => Users::DEFAULT_POINTS_SUM,
                default => $user->points_sum - $currentMembership->points_remain,
            };
            $amount = match ($currentMembership->slug) {
                MembershipTier::SLUG_GOLD => $user->points_sum,
                default => $currentMembership->points_remain,
            };
            self::addPointHistory(
                $user->id,
                self::TYPE_LOSS,
                $amount,
                null,
                self::IS_USED_UNUSABLE,
                self::IS_HIDDEN_FALSE,
                $reason,
                null
            );
            self::updateHiddenPoint(
                $amount,
                $user->id,
                $currentMembership->slug
            );
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

    /**
     * Class Constructor.
     * @param $userId (integer) Required.
     * @param $type (boolean) Required.
     * @param $amount (integer) Required.
     * @param int|null $transactionId Nullable.
     * @param $isUsed (boolean) Nullable
     * @param $isHidden (boolean) Nullable
     * @param $reason (string) Required.
     * @param $expiredDate
     * @return void
     */
    public static function addPointHistory(int $userId, bool $type, int $amount, ?int $transactionId, ?bool $isUsed, ?bool $isHidden, string $reason, $expiredDate): void
    {
        $history = new self();
        $history->user_id = $userId;
        $history->type = $type;
        $history->amount = $amount;
        $history->transaction_id = $transactionId;
        $history->is_used = $isUsed;
        $history->is_hidden = $isHidden;
        $history->reason = $reason;
        $history->expired_date = $expiredDate;
        $history->save();
    }

    public static function updateHiddenPoint($point, $userId, $currentMembership)
    {
        if ($currentMembership == MembershipTier::SLUG_GOLD) {
            $updatePointHistory = self::where('type', self::TYPE_GAIN)
                ->find($userId)
                ->update(
                    [
                        'is_hidden' => self::IS_HIDDEN_TRUE,
                        'is_used' => self::IS_USED_UNUSABLE,
                    ]
                );
            return;
        }
        $pointHistory = self::where('user_id', $userId)
            ->where('type', self::TYPE_GAIN)
            ->where('is_used', self::IS_USED_USABLE)
            ->orderBy('expired_date', 'asc')
            ->orderBy('amount', 'asc')
            ->get();
        if ($pointHistory->sum('amount') < $point) {
            return;
        }
        foreach ($pointHistory as $key => $history) {
            if ($point >= $history->amount) {
                $point -= $history->amount;
                $history->is_used = self::IS_USED_UNUSABLE;
                $history->save();
            } else {
                $newPoint = $history->amount - $point;
                $history->is_used = self::IS_USED_UNUSABLE;
                self::addPointHistory(
                    $history->user_id,
                    self::TYPE_GAIN,
                    $newPoint,
                    $history->transaction_id,
                    self::IS_USED_USABLE,
                    self::IS_HIDDEN_TRUE,
                    Lang::get('overlander.transaction::lang.point_history.gain_reason.remain', ['invoice_no' => $history->transaction->invoice_no]),
                    $history->expired_date
                );
                $history->save();
                break;
            }

        }
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
            self::addPointHistory(
                $user->id,
                self::TYPE_LOSS,
                $membershipTier->points_required,
                null,
                self::IS_USED_UNUSABLE,
                self::IS_HIDDEN_FALSE,
                Lang::get('overlander.transaction::lang.point_history.loss_reason.upgrade', ['membership' => $membershipTier->name]),
                null
            );
            if ($membershipTier->slug == MembershipTier::SLUG_GOLD) {
                $user->points_sum = Users::DEFAULT_POINTS_SUM;
                self::updateHiddenPoint(
                    Users::DEFAULT_POINTS_SUM,
                    $user->id,
                    $membershipTier->slug
                );
            } else {
                $user->points_sum = $user->points_sum - $membershipTier->points_required;
                self::updateHiddenPoint(
                    $membershipTier->points_required,
                    $user->id,
                    $membershipTier->slug
                );
            }

            $user->membership_tier_id = $membershipTier->id;
            $user->join_date = Carbon::now();
            $user->validity_date = Carbon::now()->addMonth($membershipTier->period);
            $user->save();
        }
    }

    public static function calculatePoint(): void
    {
        $transactions = Transaction::where('is_checked', Transaction::IS_CHECKED_UNCHECK)->get();
        foreach ($transactions as $key => $transaction) {
            foreach ($transaction->detail as $key => $transactionDetail) {
                $pointMultiplier = self::POINT_MULTIPLIER_COUNTER;
                $campaignUsed = [];
                $brandCampaign = Campaign::getCampaign(Campaign::TARGET_BRAND)
                    ->where('brand_id', $transactionDetail->brand_code)
                    ->first();
                $skuCampaign = Campaign::getCampaign(Campaign::TARGET_SKU)
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

            $user = Users::select('id', 'membership_tier_id')
                ->where(DB::raw('concat(member_no, member_prefix)'), $transaction->vip)
                ->first();

            $membershipCampaign = Campaign::getCampaign(Campaign::TARGET_MEMBERSHIP)
                ->where('membership_tier_id', $user->membership_tier_id)
                ->first();
            $shopCampaign = Campaign::getCampaign(Campaign::TARGET_SHOP)
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

            self::addPointHistory(
                $user->id,
                $totalPoint > 0 ? self::TYPE_GAIN : self::TYPE_LOSS,
                $totalPoint,
                $transaction->id,
                PointHistory::IS_USED_USABLE,
                PointHistory::IS_HIDDEN_FALSE,
                Lang::get('overlander.transaction::lang.point_history.gain_reason.invoice', ['invoice_no' => $transaction->invoice_no]),
                Carbon::now()->addYear(self::EXPIRED_DATE_YEAR)
            );
            $transaction->is_checked = Transaction::IS_CHECKED_CHECK;
            $transaction->campaign = array_filter($campaignUsed);
            $transaction->save();
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

    public function getMemberNoAttribute()
    {
        $user = Users::select('member_no', 'member_prefix')->find($this->user_id);
        return $user->member_no . $user->member_prefix;
    }

    public function getTypeOptions()
    {
        return [
            self::TYPE_GAIN => 'Point Gain',
            self::TYPE_LOSS => 'Point Loss',
        ];
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
