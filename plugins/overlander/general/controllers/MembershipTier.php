<?php

namespace Overlander\General\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class MembershipTier extends Controller
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
        BackendMenu::setContext('Overlander.General', 'general', 'general-membershiptier');
    }
}
