<?php

class GamesController extends BaseController {
   public function getIndex () {
      $startedGames = Game::where('result', 1)
                     ->with('team1', 'team2', 'tourney')
                     ->orderBy('id', 'desc')->get();

      $newGames = Game::where('result', 0)
                     ->with('team1', 'team2', 'tourney')
                     ->orderBy('id', 'desc')->get();

      $otherGames = Game::whereIn('result', array(2, 3, 4, 10, 20))
                     ->with('team1', 'team2', 'tourney')
                     ->orderBy('id', 'desc')->paginate(10);

      return View::make('home')
               ->with('newGames', $newGames)
               ->with('startedGames', $startedGames)
               ->with('otherGames', $otherGames);
   }

   public function getGame ($id) {
      $game = Game::with('team1', 'team2', 'tourney')->find($id);
      $myBets = array();

      if(Auth::check()) {
         $myBets = Auth::user()->bets()->where('game_id', $id)->orderBy('id', 'desc')->get();
      }

      return View::make('game')
               ->with('myBets', $myBets)
               ->with('game', $game);
   }
}