<?php

namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderUsersPointHistory extends Migration
{
    public function up()
    {
        Schema::create('overlander_users_point_history', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('vip');
            $table->string('type');
            $table->integer('amount');
            $table->string('reason');
            $table->date('transaction_date');
            $table->date('expired_date');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_users_point_history');
    }
}
