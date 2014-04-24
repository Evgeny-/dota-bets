<?php

use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
      /**
       * results
       * 0 - not start
       * 1 - start
       * 2 - cancel game
       * 3 - cancel not correct
       * 4 - ничья
       * 10 - win 1
       * 20 - win 2
       */
      Schema::create('games', function ($t) {
         $t->increments('id');
         $t->integer('tourney_id');
         $t->integer('team1_id');
         $t->integer('team2_id');
         $t->integer('start_at');
         $t->integer('ratio1');
         $t->integer('ratio2');
         $t->integer('result')->default(0);
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
		Schema::drop('games');
	}

}