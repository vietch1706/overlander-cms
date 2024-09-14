<?php

namespace Overlander\Transaction\console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
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
        $users = Users::where('status', Users::STATUS_ACTIVE)->where('is_activated', Users::STATUS_ACTIVE)->where('role_id', Users::ROLE_CUSTOMER_ID)->where(function ($query) {
            $query->whereBetween('validity_date', [Carbon::now()->subMonth(1), Carbon::now()]);
        })->chunkById(100, function (Collection $users) {
            foreach ($users as $user) {
                dd($users);
            }
        });
    }
}
