<?php namespace Overlander\Transaction\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class PointHistory extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Overlander.Transaction', 'transaction', 'side-menu-item');
    }

    public function listExtendQuery($query)
    {
        $query->where(function ($query) {
            $query
                ->where('is_halted', \Overlander\Transaction\Models\PointHistory::IS_HALTED_FALSE)
                ->where('is_used', \Overlander\Transaction\Models\PointHistory::IS_USED_USABLE);

        });
    }
}
