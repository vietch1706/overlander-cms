<?php namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOverlanderUsersInvoiceDetails extends Migration
{
    public function up()
    {
        Schema::table('overlander_users_invoice_details', function($table)
        {
            $table->renameColumn('invoice_id', 'invoice_no');
        });
    }
    
    public function down()
    {
        Schema::table('overlander_users_invoice_details', function($table)
        {
            $table->renameColumn('invoice_no', 'invoice_id');
        });
    }
}
