<?php

namespace Legato\Api\Models;

use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;

class Settings extends Model
{
    use Validation;

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'authentication_setting';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'login_timeout' => 'required|numeric',
        'validate_activate' => 'required|boolean',
        'concurrent_session_number' => 'required|numeric',
    ];

    public function initSettingsData()
    {
        $this->login_timeout = 3600*24*30;
        $this->validate_activate = 1;
        $this->concurrent_session_number = 0;
    }
}
