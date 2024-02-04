<?php

namespace Overlander\General\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderGeneralBrands extends Migration
{
    public function up()
    {
        Schema::create('overlander_general_brands', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('image');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_general_brands');
    }
}
