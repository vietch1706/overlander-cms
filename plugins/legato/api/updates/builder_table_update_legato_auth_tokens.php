<?php namespace Legato\Api\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLegatoAuthTokens extends Migration
{
    public function up()
    {
        Schema::table('legato_users_tokens', function($table)
        {
            $table->dateTime('last_active')->nullable();
        });
    }

    public function down()
    {
        Schema::table('legato_users_tokens', function($table)
        {
            $table->dropColumn('last_active');
        });
    }
}
