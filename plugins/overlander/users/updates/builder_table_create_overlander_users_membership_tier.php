<?php

namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderUsersMembershipTier extends Migration
{
    public function up()
    {
        Schema::create('overlander_users_membership_tier', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('logo');
            $table->integer('points_required');
            $table->integer('points_remain');
            $table->integer('period')->unsigned();
            $table->string('slug');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_users_membership_tier');
    }
}
