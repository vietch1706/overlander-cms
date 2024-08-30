<?php namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOverlanderUsersTransaction extends Migration
{
    public function up()
    {
        Schema::table('overlander_users_transaction', function($table)
        {
            $table->renameColumn('desciption', 'description');
        });
    }
    
    public function down()
    {
        Schema::table('overlander_users_transaction', function($table)
        {
            $table->renameColumn('description', 'desciption');
        });
    }
}
