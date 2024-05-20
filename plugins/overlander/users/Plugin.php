<?php

namespace Overlander\Users;

use Illuminate\Support\Facades\DB;
use Overlander\Users\Models\Users;
use System\Classes\PluginBase;

/**
 * Plugin class
 */
class Plugin extends PluginBase
{
    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        $this->registerConsoleCommand('overlander.userCommand', \Overlander\Users\Console\UserCommand::class);
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
    }

    /**
     * registerSettings used by the backend.
     */
    public function registerSettings()
    {
    }

    public function registerSchedule($schedule)
    {
        $schedule->call(function () {
            $users = new Users();
            $datas = $users->where('send_time', '=', 3)->get()->toArray();
            foreach ($datas as $key => $value) {
                $user = new Users();
                $updateData = [
                    'send_time' => 0,
                ];
                $user->where('member_no', $value['member_no'])->update($updateData);
            }
        })->dailyAt('00:00');
    }
}
