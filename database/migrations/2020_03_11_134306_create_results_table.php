<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {

            $table->increments('id');
            $table->text('result');

            $table->integer('user_id')->unsigned()->default(0);
                // здесь создаём поле внешнего ключа

            $table->foreign('user_id')->references('id')->on('users');
                // а здесь привязвываем данное поле к полю 'id' таблички 'users'
                // точнее указываем что 'user_id' ссылается на 'id' таблички 'users'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('results');
    }
}
