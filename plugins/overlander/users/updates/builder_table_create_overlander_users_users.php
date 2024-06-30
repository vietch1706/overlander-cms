<?php

namespace Overlander\Users\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOverlanderUsersUsers extends Migration
{
    public function up()
    {
        Schema::create('overlander_users_users', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('member_no');
            $table->string('member_prefix')->default('A');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('phone');
            $table->string('password');
            $table->string('email');
            $table->boolean('gender')->nullable();
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->integer('country_id');
            $table->boolean('e_newsletter')->default(0);
            $table->boolean('mail_receive')->default(0);
            $table->date('join_date')->nullable();
            $table->date('validity_date')->nullable();
            $table->integer('membership_tier_id')->default(0);
            $table->boolean('status')->default(0);
            $table->string('interests')->nullable();
            $table->integer('sales_amounts')->nullable();
            $table->integer('points_sum')->default(0);
            $table->timestamp('send_mail_at')->nullable();
            $table->boolean('is_existing_member')->default(0);
            $table->integer('verification_code')->nullable();
            $table->timestamp('active_date')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_users_users');
    }
}
