<?php namespace Overlander\General\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderGeneralContactreason extends Migration
{
    public function up()
    {
        Schema::create('overlander_general_contactreason', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('reason');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('overlander_general_contactreason');
    }
}
