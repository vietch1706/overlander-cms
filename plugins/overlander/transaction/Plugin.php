<?php namespace Overlander\Transaction;

use Overlander\Transaction\console\GradeDailyCheck;
use Overlander\Transaction\Models\PointHistory;
use Overlander\Transaction\Models\TransactionDetail;
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
        $this->registerConsoleCommand('overlander.gradeDailyCheck', GradeDailyCheck::class);

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
            'virtual_columns' => [$this, 'evalVirtualListsColumns'],
        ];
    }
    public function evalVirtualListsColumns($value, $column, $record)
    {
        return PointHistory::where('transaction_id', $record->id)->first()->amount;
    }
}
