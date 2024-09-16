<?php

namespace Overlander\General\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOverlanderGeneralInterests extends Migration
{
    public function up()
    {
        Schema::create('overlander_general_interests', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_general_interests');
    }
}
