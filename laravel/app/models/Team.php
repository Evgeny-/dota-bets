<?php

class Team extends Eloquent {
   protected $guarded = array();
   protected $games = null;

   protected  function selectGames() {
      if($this->games === null) {
         $this->games = Game::where('team1_id', $this->id)
                           ->orWhere('team2_id', $this->id)
                           ->select('team1_id', 'team2_id', 'result')
                           ->orderBy('id', 'desc')->get();
      }
   }

   public function countGames () {
      $this->selectGames();

      return count($this->games);
   }

   public function countWins () {
      $this->selectGames();
      $wins = 0;

      foreach($this->games as $g) {
         if($g->team1_id == $this->id) {
            if($g->result == 10) $wins++;
         }

         elseif($g->team2_id == $this->id) {
            if($g->result == 20) $wins++;
         }
      }

      return $wins;
   }

   public function countLooses () {
      $this->selectGames();

      $looses = 0;

      foreach($this->games as $g) {
         if($g->team1_id == $this->id) {
            if($g->result == 20) $looses++;
         }

         elseif($g->team2_id == $this->id) {
            if($g->result == 10) $looses++;
         }
      }

      return $looses;
   }

   public function getWinsRelative () {
      $wins = $this->countWins();
      $looses = $this->countLooses();

      if($wins + $looses === 0) return 0;

      return ceil(($wins / ($wins + $looses)) * 100);
   }
}