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
            $table->integer('member_no');
            $table->string('member_prefix')->default('A');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('password');
            $table->integer('country_id');
            $table->string('email');
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->boolean('gender')->nullable();
            $table->integer('interest_id')->nullable();
            $table->boolean('is_existing_member')->default(0);
            $table->boolean('is_active')->default(0);
            $table->timestamp('active_date')->nullable();
            $table->timestamp('send_mail_at')->nullable();
            $table->integer('verification_code')->nullable();
            $table->integer('send_time')->nullable()->default(0);
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
