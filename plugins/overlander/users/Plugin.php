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

    public function registerListColumnTypes()
    {
        return [

            // Using an inline closure
            'concatmemberno' => function ($value) {
                $users = new Users();
                $user = $users->where('member_no', $value)->first();
                return $value . $user['member_prefix'];
            },
            'concatbirthday' => [$this, 'evalConcatBirthdayListsColumn']

        ];
    }

    public function evalConcatBirthdayListsColumn($value, $column, $record)
    {
        $users = new Users();
        $user = $users->where('member_no', $record->member_no)->first();
        if ($value < 10) {
            return '0' . $value . '-' . $user['year'];
        }
        return $value . '-' . $user['year'];
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
