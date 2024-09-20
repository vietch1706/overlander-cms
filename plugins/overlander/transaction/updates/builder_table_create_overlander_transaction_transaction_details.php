<?php

namespace Overlander\Transaction\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOverlanderTransactionTransactionDetails extends Migration
{
    public function up()
    {
        Schema::create('overlander_transaction_transaction_details', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('transaction_id');
            $table->string('plc');
            $table->double('price', 10, 0);
            $table->smallInteger('quantity');
            $table->smallInteger('brand_code');
            $table->text('description');
            $table->string('unit');
            $table->double('discount', 10, 0);
            $table->double('fprice', 10, 0);
            $table->string('category');
            $table->integer('point');
            $table->smallInteger('act01')->nullable();
            $table->smallInteger('act02')->nullable();
            $table->smallInteger('act03')->nullable();
            $table->smallInteger('act04')->nullable();
            $table->smallInteger('act05')->nullable();
            $table->smallInteger('act06')->nullable();
            $table->smallInteger('act07')->nullable();
            $table->smallInteger('act08')->nullable();
            $table->smallInteger('act09')->nullable();
            $table->smallInteger('act10')->nullable();
            $table->text('campaign')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_transaction_transaction_details');
    }
}
