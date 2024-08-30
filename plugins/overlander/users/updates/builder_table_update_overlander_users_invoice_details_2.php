<?php namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOverlanderUsersInvoiceDetails2 extends Migration
{
    public function up()
    {
        Schema::table('overlander_users_invoice_details', function($table)
        {
            $table->double('product_price', 10, 0)->nullable(false)->unsigned(false)->default(null)->comment(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('overlander_users_invoice_details', function($table)
        {
            $table->binary('product_price')->nullable(false)->unsigned(false)->default(null)->comment(null)->change();
        });
    }
}
