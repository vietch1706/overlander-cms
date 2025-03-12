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

    public function registerSchedule($schedule)
    {
        $schedule->call(function () {

        })->dailyAt('00:00');
    }
}
