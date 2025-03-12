<?php namespace Overlander\Campaign\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOverlanderCampaignCampaign extends Migration
{
    public function up()
    {
        Schema::create('overlander_campaign_campaign', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->text('detail_description')->nullable();
            $table->string('image')->nullable();
            $table->text('t_c')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('target');
            $table->integer('membership_tier_id')->default(1)->nullable();
            $table->string('sku')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('shop')->nullable();
            $table->double('multiplier', 10, 0);
            $table->boolean('status');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_campaign_campaign');
    }
}
