<?php

namespace Overlander\General\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderGeneralStores extends Migration
{
    public function up()
    {
        Schema::create('overlander_general_stores', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('image');
            $table->integer('shop_id');
            $table->string('area');
            $table->string('address');
            $table->decimal('longitude', 10, 0);
            $table->decimal('latitude', 10, 0);
            $table->string('phone_number');
            $table->time('start_hour');
            $table->time('end_hour');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_general_stores');
    }
}