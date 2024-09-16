<?php

namespace Overlander\Transaction\console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Lang;
use Overlander\General\Models\MembershipTier;
use Overlander\Transaction\Models\PointHistory;
use Overlander\Transaction\Models\Transaction;
use Overlander\Users\Models\Users;

class GradeDailyCheck extends Command
{
    /**
     * @var string signature for the console command.
     */
    protected $signature = 'users:gradeDailyCheck';
    /**
     * @var string description is the console command description
     */
    protected $description = 'No description provided yet...';

    /**
     * handle executes the console command.
     */
    public function handle()
    {
        #TODO: user where status is_active validity_date(<=) role_id chunkById/chunk
        $users = Users::where('status', Users::STATUS_ACTIVE)->where('is_activated', Users::STATUS_ACTIVE)
            ->where('deleted_at', null)
            ->where('role_id', Users::ROLE_CUSTOMER_ID)
            ->where(function ($query) {
                $query
                    ->whereBetween('validity_date', [Carbon::now()->subMonth(1), Carbon::now()]);
            })
            ->chunkById(100, function ($users) {
                foreach ($users as $user) {
                    $membershipTier = MembershipTier::where('id', $user->membership_tier_id)->first();
                    $purchaseRecord = Transaction::where('vip', $user->member_no . $user->member_prefix)
                        ->where(function ($query) use ($user) {
                            $query
                                ->whereBetween('date', [$user->join_date, $user->validity_date]);
                        })
                        ->orderBy('date', 'desc')
                        ->get();
                    if ($purchaseRecord->count() == 0) {
                        switch ($membershipTier->slug) {
                            case MembershipTier::SLUG_TEMPORARY:
                                $user->deleted_at = Carbon::now();
                                $user->save();
                                return $this->output->writeln(Lang::get('overlander.transaction::lang.transaction.delete'));
                            case MembershipTier::SLUG_ORDINARY:
                                $user->is_activated = Users::STATUS_INACTIVE;
                                $user->save();
                                return $this->output->writeln(Lang::get('overlander.transaction::lang.transaction.archived'));
                        }
                    }
                    switch ($membershipTier->slug) {
                        case MembershipTier::SLUG_TEMPORARY:
                        case MembershipTier::SLUG_ORDINARY:
                            $user->validity_date = Carbon::now()->addMonth($membershipTier->period);
                            $user->save();
                            return $this->output->writeln('hehe');
                            break;
                        case MembershipTier::SLUG_VIP:
                        case MembershipTier::SLUG_GOLD:
                            if ($user->points_sum >= $membershipTier->points_remain) {
                                $user->points_sum -= $membershipTier->points_remain;
                                $user->save();
                                $reason = Lang::get('overlander.transaction::lang.transaction.remain', ['membership' => $membershipTier->name]);
                                PointHistory::addPointHistory($user->member_no . $user->member_prefix, $membershipTier->points_remain, null, $reason);
                            } else {
                                $user->membership_tier_id -= 1;
                                $user->validity_date = Carbon::now()->addMonth($membershipTier->period);
                                $user->save();
                            }
                            break;
                        case MembershipTier::SLUG_PLATINUM:
                        case MembershipTier::SLUG_PREMIER:
                            $membershipTiers = MembershipTier::where('group', MembershipTier::GROUP_AUTOMATIC)->orderBy('points_remain', 'desc')->get();
                            foreach ($membershipTiers as $key => $membershipTier) {
                                if ($user->points_sum > $membershipTier->points_remain) {
                                    $user->membership_tier_id = $membershipTier->id;
                                    $user->save();
                                }
                            }
                            break;

                    }
                }
        });
    }
}
