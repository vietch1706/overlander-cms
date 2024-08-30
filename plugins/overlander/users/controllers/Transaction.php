<?php

namespace Overlander\Users\Controllers;

use Backend;
use BackendMenu;
use Backend\Classes\Controller;

class Transaction extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\ImportExportController::class
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Overlander.Users', 'Users', 'users-transaction');
    }
}
