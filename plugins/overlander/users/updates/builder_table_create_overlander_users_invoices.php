<?php namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderUsersInvoices extends Migration
{
    public function up()
    {
        Schema::create('overlander_users_invoices', function($table)
        {
            $table->increments('id')->unsigned();
            $table->text('number');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('overlander_users_invoices');
    }
}
