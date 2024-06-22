<?php namespace Overlander\General\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOverlanderGeneralVerificationQuestions extends Migration
{
    public function up()
    {
        Schema::create('overlander_general_verification_questions', function ($table) {
            $table->increments('id')->unsigned();
            $table->text('name');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overlander_general_verification_questions');
    }
}
