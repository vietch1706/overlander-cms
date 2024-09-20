<?php namespace Overlander\Transaction\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use Backend\Classes\Controller;
use BackendMenu;

class PointHistory extends Controller
{
    public $implement = [
        FormController::class,
        ListController::class
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
                ->where('is_hidden', \Overlander\Transaction\Models\PointHistory::IS_HIDDEN_FALSE);
        });
    }
}
