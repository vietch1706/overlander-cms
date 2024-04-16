<?php

namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderUsersTransaction extends Migration
{
    public function up()
    {
        Schema::create('overlander_users_transaction', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('member_no');
            $table->string('name');
            $table->integer('plc');
            $table->string('desciption');
            $table->string('invoice');
            $table->date('date');
            $table->smallInteger('quantity');
            $table->string('unit');
            $table->double('price', 10, 0);
            $table->double('discount', 10, 0);
            $table->double('fprice', 10, 0);
            $table->string('shop_id');
            $table->string('category');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_users_transaction');
    }
}
