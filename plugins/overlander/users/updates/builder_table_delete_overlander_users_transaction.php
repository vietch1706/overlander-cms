<?php namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteOverlanderUsersTransaction extends Migration
{
    public function up()
    {
        Schema::dropIfExists('overlander_users_transaction');
    }
    
    public function down()
    {
        Schema::create('overlander_users_transaction', function($table)
        {
            $table->increments('id')->unsigned();
            $table->text('name');
            $table->date('date');
            $table->smallInteger('loyaly_balance');
            $table->string('shop_id', 255);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('vip', 255);
            $table->string('invoice_code', 255);
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
        });
    }
}
