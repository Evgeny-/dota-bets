<?php

use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
      Schema::create('teams', function ($t) {
         $t->increments('id');
         $t->string('name');
         $t->string('image');
         $t->integer('wins')->default(0);
         $t->integer('looses')->default(0);
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
		Schema::drop('teams');
	}

}