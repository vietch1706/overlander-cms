<?php

namespace Overlander\Users\Updates;

use Backend\Models\UserRole;
use Overlander\Users\Models\Users;

class seed_user_roles extends \Seeder
{
    public function run()
    {
        UserRole::truncate();

        $role = new UserRole();
        $role->id = Users::ROLE_ADMIN_ID;
        $role->name = ucfirst(Users::ROLE_ADMIN_CODE);
        $role->code = Users::ROLE_ADMIN_CODE;
        $role->is_system = 1;
        $role->save();

        $role = new UserRole();
        $role->id = Users::ROLE_EMPLOYEE_ID;
        $role->name = ucfirst(Users::ROLE_EMPLOYEE_CODE);
        $role->code = Users::ROLE_EMPLOYEE_CODE;
        $role->is_system = 1;
        $role->save();

        $role = new UserRole();
        $role->id = Users::ROLE_CUSTOMER_ID;
        $role->name = ucfirst(Users::ROLE_CUSTOMER_CODE);
        $role->code = Users::ROLE_CUSTOMER_CODE;
        $role->is_system = 1;
        $role->save();
    }
}
