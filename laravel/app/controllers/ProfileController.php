<?php

class ProfileController extends BaseController {
   public function __construct() {
      $this->beforeFilter(function () {
         if(! Auth::check() || Auth::user()->admin != 1) {
            return Redirect::to('/');
         }
      });
   }

   public function getIndex () {
      $bets = Auth::user()->bets()->orderBy('id', 'desc')->with('game', 'team')->paginate(8);

      return View::make('profile')
               ->with('bets', $bets);
   }

   public function getCashin () {
      $pays = Auth::user()->pays()->orderBy('id', 'desc')->get();

      return View::make('cashin')
               ->with('pays', $pays);
   }

   public function getCashout () {
      $pays = Auth::user()->backPays()->orderBy('id', 'desc')->get();

      return View::make('cashout')
               ->with('pays', $pays);
   }
}