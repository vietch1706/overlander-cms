<?php namespace Overlander\Transaction\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOverlanderTransactionInvoiceDetails extends Migration
{
    public function up()
    {
        Schema::table('overlander_transaction_invoice_details', function($table)
        {
            $table->integer('transaction_id');
            $table->dropColumn('invoice_no');
        });
    }
    
    public function down()
    {
        Schema::table('overlander_transaction_invoice_details', function($table)
        {
            $table->dropColumn('transaction_id');
            $table->string('invoice_no', 255);
        });
    }
}
