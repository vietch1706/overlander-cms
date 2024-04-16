<?php

namespace Overlander\Users\Controllers;

use Backend;
use BackendMenu;
use Backend\Classes\Controller;

class PointHistory extends Controller
{
    public $implement = [
        \Backend\Behaviors\ListController::class
    ];

    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Overlander.Users', 'Users', 'users-point-history');
    }
}
