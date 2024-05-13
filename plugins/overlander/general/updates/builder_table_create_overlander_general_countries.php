<?php

namespace Overlander\General\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderGeneralCountries extends Migration
{
    public function up()
    {
        Schema::create('overlander_general_countries', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('iso')->nullable();
            $table->string('name');
            $table->string('iso3')->nullable();
            $table->smallInteger('numcode')->nullable();
            $table->smallInteger('phonecode');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_general_countries');
    }
}
