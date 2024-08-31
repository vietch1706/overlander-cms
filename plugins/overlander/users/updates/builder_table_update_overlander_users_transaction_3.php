<?php namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOverlanderUsersTransaction3 extends Migration
{
    public function up()
    {
        Schema::table('overlander_users_transaction', function($table)
        {
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
            $table->text('name')->nullable(false)->unsigned(false)->default(null)->comment(null)->change();
            $table->renameColumn('quantity', 'loyaly_balance');
            $table->dropColumn('member_no');
            $table->dropColumn('plc');
            $table->dropColumn('description');
            $table->dropColumn('invoice');
            $table->dropColumn('unit');
            $table->dropColumn('price');
            $table->dropColumn('discount');
            $table->dropColumn('fprice');
            $table->dropColumn('category');
            $table->dropColumn('loyalty_balance');
        });
    }
    
    public function down()
    {
        Schema::table('overlander_users_transaction', function($table)
        {
            $table->dropColumn('vip');
            $table->dropColumn('invoice_code');
            $table->dropColumn('act01');
            $table->dropColumn('act02');
            $table->dropColumn('act03');
            $table->dropColumn('act04');
            $table->dropColumn('act05');
            $table->dropColumn('act06');
            $table->dropColumn('act07');
            $table->dropColumn('act08');
            $table->dropColumn('act09');
            $table->dropColumn('act10');
            $table->string('name', 255)->nullable(false)->unsigned(false)->default(null)->comment(null)->change();
            $table->renameColumn('loyaly_balance', 'quantity');
            $table->string('member_no', 255);
            $table->integer('plc');
            $table->string('description', 255);
            $table->string('invoice', 255);
            $table->string('unit', 255);
            $table->double('price', 10, 0);
            $table->double('discount', 10, 0);
            $table->double('fprice', 10, 0);
            $table->string('category', 255);
            $table->double('loyalty_balance', 10, 0);
        });
    }
}
