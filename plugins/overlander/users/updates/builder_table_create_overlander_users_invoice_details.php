<?php namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderUsersInvoiceDetails extends Migration
{
    public function up()
    {
        Schema::create('overlander_users_invoice_details', function($table)
        {
            $table->increments('id')->unsigned();
            $table->integer('invoice_id');
            $table->text('product');
            $table->binary('product_price');
            $table->smallInteger('quantity');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('overlander_users_invoice_details');
    }
}
