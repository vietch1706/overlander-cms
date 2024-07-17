<?php namespace Legato\Api\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTokensTable extends Migration
{
    public function up()
    {
        Schema::create('legato_users_tokens', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('token', 42)->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('legato_users_tokens');
    }
}
