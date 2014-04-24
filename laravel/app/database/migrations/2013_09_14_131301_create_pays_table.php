<?php

use Illuminate\Database\Migrations\Migration;

class CreatePaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
      Schema::create('pays', function ($t) {
         $t->increments('id');
         $t->integer('summ');
         $t->integer('user_id');
         $t->integer('status');
         $t->string('reason');
         $t->string('charge_id');
         $t->boolean('is_back')->default(0);
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
		Schema::drop('pays');
	}

}