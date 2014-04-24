<?php

use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface {
   protected $guarded = array();
	protected $table = 'users';

   public static function createFromSteam ($data)
   {
      if($user = static::where('steam_id', '=', $data->steamID64)->first())
      {
         $user->steam_id = $data->steamID64;
         $user->image    = $data->avatarMedium;
         $user->name     = $data->steamID;
         $user->save();
      }
      else
      {
         $data = array(
            'steam_id' => $data->steamID64,
            'image'    => $data->avatarMedium,
            'name'     => $data->steamID
         );

         $user = static::create($data);
      }

      Auth::login($user);
   }

   public function getAuthIdentifier() {
      return $this->id;
   }

   public function getAuthPassword() {
      return null;
   }

   public function bets() {
      return $this->hasMany('Bet');
   }

   public function pays() {
      return $this->hasMany('Pay')->where('is_back', 0);
   }

   public function backPays() {
      return $this->hasMany('Pay')->where('is_back', 1);
   }
}