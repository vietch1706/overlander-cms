<?php namespace Overlander\General\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderGeneralBackground extends Migration
{
    public function up()
    {
        Schema::create('overlander_general_background', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('splash_screen');
            $table->date('publish_date');
            $table->date('end_date');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('overlander_general_background');
    }
}
