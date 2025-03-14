<?php

namespace Overlander\General\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderGeneralBanner extends Migration
{
    public function up()
    {
        Schema::create('overlander_general_banner', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->date('published_at')->nullable();
            $table->date('expired_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_general_banner');
    }
}
