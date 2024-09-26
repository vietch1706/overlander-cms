<?php

namespace Overlander\Transaction\console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Lang;
use Overlander\Transaction\Models\PointHistory;
use Overlander\Users\Models\Users;

class PointExpired extends Command
{
    /**
     * @var string signature for the console command.
     */
    protected $signature = 'users:pointExpired';
    /**
     * @var string description is the console command description
     */
    protected $description = 'Daily Check for expired point';


    /**
     * handle executes the console command.
     */
    public function handle()
    {
        $pointHistories = PointHistory::where('is_used', PointHistory::IS_USED_USABLE)
            ->where('type', PointHistory::TYPE_GAIN)
            ->where('expired_date', '<=', Carbon::now())
            ->chunkById(100, function ($pointHistories) {
                foreach ($pointHistories as $pointHistory) {
                    $pointHistory->is_used = PointHistory::IS_USED_UNUSABLE;
                    $pointHistory->save();

                    $user = Users::find($pointHistory->user_id)->first();
                    if (!empty($user)) {
                        $user->points_sum = $user->points_sum - $pointHistory->amount;
                        $user->save();
                    }
                    PointHistory::addPointHistory(
                        $pointHistory->user_id,
                        PointHistory::TYPE_LOSS,
                        $pointHistory->amount,
                        null,
                        PointHistory::IS_USED_UNUSABLE,
                        PointHistory::IS_HIDDEN_FALSE,
                        Lang::get('overlander.transaction::lang.point_history.loss_reason.expired'),
                        null
                    );
                }
            });
    }
}
