<?php namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOverlanderUsersUsers2 extends Migration
{
    public function up()
    {
        Schema::table('overlander_users_users', function($table)
        {
            $table->boolean('gender')->nullable(false)->unsigned(false)->default(0)->comment(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('overlander_users_users', function($table)
        {
            $table->string('gender', 255)->nullable(false)->unsigned(false)->default(null)->comment(null)->change();
        });
    }
}
