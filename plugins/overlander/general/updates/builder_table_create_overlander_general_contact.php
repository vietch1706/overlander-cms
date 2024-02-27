<?php

namespace Overlander\General\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderGeneralContact extends Migration
{
    public function up()
    {
        Schema::create('overlander_general_contact', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('email');
            $table->string('reason');
            $table->string('title');
            $table->text('message');
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_general_contact');
    }
}
