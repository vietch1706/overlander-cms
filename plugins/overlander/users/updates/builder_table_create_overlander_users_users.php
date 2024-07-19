<?php

namespace Overlander\Users\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOverlanderUsersUsers extends Migration
{
    public function up()
    {
        Schema::table('backend_users', function ($table) {
            $table->string('member_no')->nullable();
            $table->string('phone_area_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('member_prefix')->default('A');
            $table->boolean('gender')->nullable();
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->integer('country_id')->nullable();
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
            $table->dropColumn('member_prefix');
            $table->dropColumn('gender');
            $table->dropColumn('month');
            $table->dropColumn('year');
            $table->dropColumn('address');
            $table->dropColumn('district');
            $table->dropColumn('country_id');
            $table->dropColumn('e_newsletter');
            $table->dropColumn('mail_receive');
            $table->dropColumn('join_date');
            $table->dropColumn('validity_date');
            $table->dropColumn('membership_tier_id');
            $table->dropColumn('status');
            $table->dropColumn('interests');
            $table->dropColumn('sales_amounts');
            $table->dropColumn('points_sum');
            $table->dropColumn('send_mail_at');
            $table->dropColumn('is_existing_member');
        });
    }
}
