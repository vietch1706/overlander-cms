<?php namespace Overlander\General\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderGeneralBrands extends Migration
{
    public function up()
    {
        Schema::create('overlander_general_brands', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('brands');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('overlander_general_brands');
    }
}
