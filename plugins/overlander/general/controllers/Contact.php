<?php namespace Overlander\General\Controllers;

use Backend;
use BackendMenu;
use Backend\Classes\Controller;

class Contact extends Controller
{
    public $implement = [
        \Backend\Behaviors\ListController::class
    ];

    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
    }

}
