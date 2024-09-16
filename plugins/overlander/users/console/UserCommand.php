<?php

namespace Overlander\Users\Console;

use Illuminate\Console\Command;
use Overlander\Users\Models\Users;

/**
 * UserCommand Command
 *
 * @link https://docs.octobercms.com/3.x/extend/console-commands.html
 */
class UserCommand extends Command
{
    /**
     * @var string signature for the console command.
     */
    protected $signature = 'users:resetsendcodetime';

    /**
     * @var string description is the console command description
     */
    protected $description = 'No description provided yet...';

    /**
     * handle executes the console command.
     */
    public function handle()
    {
        $users = new Users();
        $datas = $users->where('send_time', '=', 3)->get()->toArray();
        if (empty($datas)) {
            return $this->output->writeln("Every users send code times have been reset!");
        }
        foreach ($datas as $key => $value) {
            $user = new Users();
            $updateData = [
                'send_time' => 0,
            ];
            $user->where('member_no', $value['member_no'])->update($updateData);
        }
        return $this->output->writeln("Reset send code times successfully!");
    }
}
