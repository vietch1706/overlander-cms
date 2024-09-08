<?php

namespace Overlander\Transaction\console;

use Carbon\Carbon;
use Lang;
use Illuminate\Console\Command;
use Overlander\General\Models\MembershipTier;
use Overlander\Transaction\Models\PointHistory;
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
        $start_date = Carbon::create('2024', '09', '01');
        $end_date = Carbon::create('2024', '09', '30');
        $today = Carbon::create('2024', '09', '07');
        if ($today->between($start_date, $end_date)) {
            $this->output->writeln("In If");
        }

    }
}
