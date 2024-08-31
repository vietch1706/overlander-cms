<?php namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOverlanderUsersInvoiceDetails3 extends Migration
{
    public function up()
    {
        Schema::table('overlander_users_invoice_details', function($table)
        {
            $table->smallInteger('brand_code');
            $table->text('description');
            $table->smallInteger('unit');
            $table->double('discount', 10, 0);
            $table->double('fprice', 10, 0);
            $table->smallInteger('category');
            $table->renameColumn('product', 'plc');
            $table->renameColumn('product_price', 'price');
        });
    }
    
    public function down()
    {
        Schema::table('overlander_users_invoice_details', function($table)
        {
            $table->dropColumn('brand_code');
            $table->dropColumn('description');
            $table->dropColumn('unit');
            $table->dropColumn('discount');
            $table->dropColumn('fprice');
            $table->dropColumn('category');
            $table->renameColumn('plc', 'product');
            $table->renameColumn('price', 'product_price');
        });
    }
}
