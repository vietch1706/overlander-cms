<?php

namespace Overlander\General\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOverlanderGeneralBrands extends Migration
{
    public function up()
    {
        Schema::create('overlander_general_brands', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('image');
            $table->integer('code');
            $table->integer('group')->default(0);
            $table->text('description')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_general_brands');
    }
}
