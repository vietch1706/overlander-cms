<?php namespace Overlander\Users\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ImportExportController;
use Backend\Behaviors\ListController;
use Backend\Classes\Controller;
use BackendMenu;

class Users extends Controller
{
    public $implement = [
        FormController::class,
        ListController::class,
        ImportExportController::class
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Overlander.Users', 'Users', 'users-users');
    }

}
