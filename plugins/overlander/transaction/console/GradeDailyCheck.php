<?php

namespace Overlander\Transaction\console;

use Illuminate\Console\Command;
use Overlander\General\Models\MembershipTier;
use Overlander\Transaction\Models\PointHistory;

class GradeDailyCheck extends Command
{
    public const MAX_USERS = 100;
    /**
     * @var string signature for the console command.
     */
    protected $signature = 'users:gradeDailyCheck';
    /**
     * @var string description is the console command description
     */
    protected $description = 'Daily membership tier downgrade and remain';

    /**
     * handle executes the console command.
     */
    public function handle()
    {
        PointHistory::updateHiddenPoint(750, '000002A', MembershipTier::where('id', 4)->first());
//        $users = Users::where('status', Users::STATUS_ACTIVE)
//            ->where('is_activated', Users::IS_ACTIVATED_ACTIVATE)
//            ->where('deleted_at', null)
//            ->where('role_id', Users::ROLE_CUSTOMER_ID)
//            ->whereDate('validity_date', '<=', Carbon::now())
//            ->chunkById(self::MAX_USERS, function ($users) {
//                foreach ($users as $user) {
//                    $currentMembership = MembershipTier::select('id', 'name', 'points_remain', 'period', 'slug')
//                        ->where('id', $user->membership_tier_id)
//                        ->first();
//                    switch ($currentMembership->slug) {
//                        case MembershipTier::SLUG_TEMPORARY:
//                            $user->deleted_at = Carbon::now();
//                            $user->save();
//                            break;
//                        case MembershipTier::SLUG_ORDINARY:
//                            $purchaseRecord = Transaction::where('vip', $user->member_no . $user->member_prefix)
//                                ->whereBetween('date', [$user->join_date, $user->validity_date])
//                                ->orderBy('date', 'desc')
//                                ->first();
//                            if (empty($purchaseRecord)) {
//                                $user->is_activated = Users::STATUS_INACTIVE;
//                                $user->save();
//                                break;
//                            }
//                        #TODO: continue if no purchase record detect,
//                        case MembershipTier::SLUG_VIP:
//                        case MembershipTier::SLUG_GOLD:
//                            $reason = Lang::get('overlander.transaction::lang.point_history.loss_reason.remain', ['membership' => $currentMembership->name]);
//                            PointHistory::gradeDailyCheck($user, $currentMembership, $reason);
//                            break;
//                        case MembershipTier::SLUG_PLATINUM:
//                        case MembershipTier::SLUG_PREMIER:
//                            $membershipTier = MembershipTier::select('id', 'name', 'points_remain', 'perio9d', 'slug')
//                                ->where('group', MembershipTier::GROUP_AUTOMATIC)
//                                ->where('points_remain', '<=', $user->points_sum)
//                                ->orderBy('points_remain', 'desc')
//                                ->first();
//                            $reason = Lang::get('overlander.transaction::lang.point_history.loss_reason.downgrade', ['membership' => $membershipTier->name]);
//                            #TODO: add deduct point when downgrade, add point history
//
//                            PointHistory::gradeDailyCheck($user, $membershipTier, $reason);
//                            break;
//                    }
//                }
//            });
    }
}
