<?php

namespace Overlander\Transaction\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOverlanderTransactionTransaction extends Migration
{
    public function up()
    {
        Schema::create('overlander_transaction_transaction', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('vip', 255);
            $table->string('name');
            $table->string('invoice_no', 255);
            $table->date('date');
            $table->double('loyalty_balance', 10, 0);
            $table->string('shop_id');
            $table->text('campaign')->nullable();
            $table->boolean('is_checked')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_transaction_transaction');
    }
}
