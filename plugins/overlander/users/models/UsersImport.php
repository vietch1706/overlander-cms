<?php

namespace Overlander\Users\Models;

use Backend\Models\ImportModel;
use Exception;

class UsersImport extends ImportModel
{

    /**
     * @inheritDoc
     */
    public $rules = [
    ];

    public function importData($results, $sessionKey = null)
    {
        // TODO: Implement importData() method.
        foreach ($results as $row => $data) {

            try {
                $user = new Users();
                $user->fill($data);
                $user->save();

                $this->logCreated();
            } catch (Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }

        }
    }
}
