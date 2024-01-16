<?php namespace Overlander\General\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderGeneralSupportivepage extends Migration
{
    public function up()
    {
        Schema::create('overlander_general_supportivepage', function($table)
        {
            $table->text('terms');
            $table->text('policy');
            $table->text('disclaimer');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('overlander_general_supportivepage');
    }
}
