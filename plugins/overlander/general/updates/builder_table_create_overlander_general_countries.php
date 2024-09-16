<?php

namespace Overlander\General\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOverlanderGeneralCountries extends Migration
{
    public function up()
    {
        Schema::create('overlander_general_countries', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('country')->nullable();
            $table->SmallInteger('code')->nullable();
            $table->string('image')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_general_countries');
    }
}
