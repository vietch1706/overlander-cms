<?php

namespace Overlander\Users\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOverlanderUsersUsers extends Migration
{
    public function up()
    {
        Schema::table('backend_users', function ($table) {
//            $table->increments('id')->unsigned();
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
        });
    }

    public function down()
    {
//        Schema::dropIfExists('overlander_users_users');
        Schema::table('backend_users', function ($table) {
            $table->dropColumn('member_no');
            $table->dropColumn('phone_area_code');
            $table->dropColumn('phone');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('month_of_birth');
            $table->dropColumn('membership_tier_code');
            $table->dropColumn('membership_tier_start_date');
            $table->dropColumn('membership_tier_end_date');
            $table->dropColumn('point');
            $table->dropColumn('gem');
            $table->dropColumn('status');
            $table->dropColumn('referral_code');
            $table->dropColumn('is_existing_member');
            $table->dropColumn('subscribe_email_token');
            $table->dropColumn('subscribe_email_token_expire_time');
            $table->dropColumn('subscribed');
            $table->dropColumn('email_verify');
            $table->dropColumn('last_time_update_from_pos');
            $table->dropColumn('received_welcome_coupon');
            $table->dropColumn('point_next_level');
            $table->dropColumn('member_join_date');
            $table->dropColumn('point_end_date');
            $table->dropColumn('is_read_gem');
            $table->dropColumn('is_edit_birthday');
            $table->dropColumn('is_create_d365');
            $table->dropColumn('is_sync_d365');
        });
    }
}
