<?php namespace Overlander\General\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderGeneralSupportivepages extends Migration
{
    public function up()
    {
        Schema::create('overlander_general_supportivepages', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->text('contents');
            $table->string('status');
            $table->string('slug');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_general_supportivepages');
    }
}
