<?php namespace Overlander\Transaction\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ImportExportController;
use Backend\Behaviors\ListController;
use Backend\Behaviors\RelationController;
use Backend\Classes\Controller;
use BackendMenu;

class Transaction extends Controller
{
    public $implement = [
        FormController::class,
        ListController::class,
        RelationController::class,
        ImportExportController::class,
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_import_export.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Overlander.Transaction', 'transaction', 'transaction-entity');
    }

}
