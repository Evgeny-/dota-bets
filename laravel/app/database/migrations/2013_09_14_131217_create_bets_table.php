<?php

use Illuminate\Database\Migrations\Migration;

class CreateBetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
      Schema::create('bets', function ($t) {
         $t->increments('id');
         $t->integer('user_id');
         $t->integer('game_id');
         $t->integer('team_id');
         $t->integer('summ');
         $t->integer('result_summ');
         $t->integer('result');
         $t->timestamps();
      });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bets');
	}

}