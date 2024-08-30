<?php

namespace Overlander\Users;

use Overlander\General\Models\Countries;
use Overlander\Users\Console\UserCommand;
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
        $this->registerConsoleCommand('overlander.userCommand', UserCommand::class);
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
                if ($user['member_no'] === null) {
                    return '';
                }
                return $value . $user['member_prefix'];
            },
            'concatbirthday' => [$this, 'evalConcatBirthdayListsColumn'],
            'concatphone' => function ($value) {
                $users = new Users();
                $user = $users->where('phone', $value)->first();
                if ($user['phone'] === null) {
                    return '';
                }
//                dd($phoneCode->where('id', $user['phone_area_code'])->first());
                return $user['phone_area_code'] . $value;
            },

        ];
    }

    public function evalConcatBirthdayListsColumn($value, $column, $record)
    {
        $users = new Users();
        $user = $users->where('email', $record->email)->first();
        if ($user['member_no'] === null) {
            return '';
        }
        if ($value < 10) {
            return '0' . $value . '-' . $user['year'];
        }
        return $value . '-' . $user['year'];
    }

    public function registerSchedule($schedule)
    {
        $schedule->call(function () {

        })->dailyAt('00:00');
    }
}
