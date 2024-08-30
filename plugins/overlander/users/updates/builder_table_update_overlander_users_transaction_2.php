<?php namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOverlanderUsersTransaction2 extends Migration
{
    public function up()
    {
        Schema::table('overlander_users_transaction', function($table)
        {
            $table->double('loyalty_balance', 10, 0);
        });
    }
    
    public function down()
    {
        Schema::table('overlander_users_transaction', function($table)
        {
            $table->dropColumn('loyalty_balance');
        });
    }
}
