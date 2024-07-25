<?php

namespace Legato\Api\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateBackendUsersTable extends Migration
{
    public function up()
    {
        Schema::table('backend_users', function($table)
        {
            $table->string('login_type', 20)->nullable()->default('email');
        });
    }

    public function down()
    {
        Schema::table('backend_users', function($table)
        {
            $table->dropColumn('login_type');
        });
    }
}
