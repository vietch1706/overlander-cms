<?php

namespace Overlander\Transaction\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOverlanderTransactionPointHistory extends Migration
{
    public function up()
    {
        Schema::create('overlander_transaction_point_history', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('member_no');
            $table->string('type');
            $table->integer('amount');
            $table->text('reason');
            $table->integer('transaction_id')->nullable();
            $table->boolean('is_used')->nullable();
            $table->boolean('is_hidden')->nullable();
            $table->date('expired_date')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_transaction_point_history');
    }
}
