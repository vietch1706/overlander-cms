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
            $table->string('image');
            $table->string('link');
            $table->date('published_at')->nullable();
            $table->date('expired_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_general_banner');
    }
}
