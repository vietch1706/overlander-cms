<?php

namespace Overlander\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOverlanderUsersUsers extends Migration
{
    public function up()
    {
        Schema::table('overlander_users_users', function ($table) {
            // $table->boolean('is_existing_member')->default(0);
            $table->string('interest', 255)->nullable()->change();
            $table->integer('points')->default(0)->change();
            $table->integer('membership_tier_id')->default(0)->change();
            $table->dropColumn('is_existing');
        });
    }

    public function down()
    {
        Schema::table('overlander_users_users', function ($table) {
            // $table->dropColumn('is_existing_member');
            $table->string('interest', 255)->nullable(false)->change();
            $table->integer('points')->default(null)->change();
            $table->integer('membership_tier_id')->default(null)->change();
            $table->string('is_existing', 255);
        });
    }
}
