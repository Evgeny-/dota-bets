<?php

class HomeController extends BaseController {

   public function getLogin()
   {
      if(!Session::has('return-url')) Session::put('return-url', URL::previous());

      $steam = new Steam;
      $steam->signIn();

      return Redirect::to('/join');
   }

   public function getLogout()
   {
      Auth::logout();

      return Redirect::back();
   }

   public function getJoin()
   {
      if(Session::has('return-url')) {
         $url = Session::get('return-url');
         Session::forget('return-url');
      }
      else {
         $url = "/";
      }

      $steam = new Steam();
      $info = $steam->getUserInfo(Session::get('login'));

      User::createFromSteam($info);

      return Redirect::to($url);
   }

   public function getHelp () {
      return View::make('help');
   }

}