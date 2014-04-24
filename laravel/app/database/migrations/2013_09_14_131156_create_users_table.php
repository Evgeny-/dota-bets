<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('users', function ($t) {
         $t->increments('id');
         $t->string('name');
         $t->string('image');
         $t->string('steam_id');
         $t->string('admin')->default(0);
         $t->integer('balance')->default(0);
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
      Schema::drop('users');
   }

}