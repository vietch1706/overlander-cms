<?php

namespace Overlander\Transaction\console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Lang;
use Overlander\Transaction\Models\PointHistory;

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
                    PointHistory::addPointHistory(
                        $pointHistory->member_no,
                        PointHistory::TYPE_LOSS,
                        $pointHistory->amount,
                        $pointHistory->transaction_id,
                        PointHistory::IS_HIDDEN_FALSE,
                        PointHistory::IS_USED_UNUSABLE,
                        Lang::get('overlander.transaction::lang.point_history.loss_reason.expired'),
                        null
                    );
                }
            });
    }
}
