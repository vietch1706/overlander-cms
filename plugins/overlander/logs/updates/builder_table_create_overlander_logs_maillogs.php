<?php namespace Overlander\Logs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderLogsMaillogs extends Migration
{
    public function up()
    {
        Schema::create('overlander_logs_maillogs', function($table)
        {
            $table->increments('id')->unsigned();
            $table->text('email');
            $table->text('content');
            $table->text('method');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('overlander_logs_maillogs');
    }
}
