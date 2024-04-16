<?php

namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOverlanderUsersUsers extends Migration
{
    public function up()
    {
        Schema::create('overlander_users_users', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('member_no');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('password');
            $table->string('country');
            $table->string('email');
            $table->date('birthday')->nullable();
            $table->boolean('gender');
            $table->string('interest')->nullable();
            $table->string('address');
            $table->boolean('is_existing_member')->default(0);
            $table->boolean('is_active')->default(0);
            $table->timestamp('active_date')->nullable();
            $table->integer('points')->default(0);
            $table->integer('membership_tier_id')->default(0);
            $table->date('published_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_users_users');
    }
}
