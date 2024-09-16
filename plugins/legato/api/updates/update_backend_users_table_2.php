<?php

namespace Legato\Api\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateBackendUsersTable2 extends Migration
{
    public function up()
    {
        Schema::table('backend_users', function($table)
        {
            $table->text('social_identity')->nullable();
        });
    }

    public function down()
    {
        Schema::table('backend_users', function($table)
        {
            $table->dropColumn('social_identity');
        });
    }
}
