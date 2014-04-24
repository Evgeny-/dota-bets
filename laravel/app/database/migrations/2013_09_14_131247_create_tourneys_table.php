<?php

use Illuminate\Database\Migrations\Migration;

class CreateTourneysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
      Schema::create('tourneys', function ($t) {
         $t->increments('id');
         $t->string('name');
         $t->string('image');
         $t->string('description');
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
		Schema::drop('tourneys');
	}

}