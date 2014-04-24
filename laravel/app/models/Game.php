<?php

class Game extends Eloquent {
   protected $guarded = array();

   public static $results = array(
      0 => 'игра еще не началась',
      1 => 'игра началась',
      2 => 'игра отменена',
      3 => 'отмена по тех. причине',
      4 => 'ничья',
      10 => 'победа первой команды',
      20 => 'победа второй команды'
   );

   public function getTime () {
      return date('H:i', $this->start_at);
   }

   public function getDate () {
      return date('d/m/Y', $this->start_at);
   }

   public function team1() {
      return $this->belongsTo('Team');
   }

   public function team2() {
      return $this->belongsTo('Team');
   }

   public function tourney() {
      return $this->belongsTo('Tourney');
   }

   public function bets() {
      return $this->hasMany('Bet');
   }

   public static function checkForResult () {
      $games = static::where('result', 0)->where('start_at', '<', time())->get();

      foreach($games as $game) {
         $game->result = 1;
         $game->save();
      }
   }

   public function getResult () {
      if($this->result == 10) {
         return "победили " . $this->team1->name;
      }

      if($this->result == 20) {
         return "победили " . $this->team2->name;
      }

      return static::$results[$this->result];
   }

   public function getPreviousGames () {
      $teams = array($this->team1_id, $this->team2_id);

      $games = static::whereIn('team1_id', $teams)
                     ->whereIn('team2_id', $teams)
                     ->whereNotIn('id', array($this->id))
                     ->with('team1', 'team2', 'tourney')
                     ->orderBy('id', 'desc')->get();

      return $games;
   }

   public function setResult ($result) {
      $result = (int) $result;

      if(in_array($result, array(2,3,4))) {
         $bets = $this->bets;

         foreach($bets as $bet) {
            $bet->setResult($bet->summ, $result);
         }
      }

      if(in_array($result, array(10, 20))) {
         $bets = $this->bets;
         $ratio = $this->getRatio();
         $winId = $result == 10 ? $this->team1_id : $this->team2_id;

         foreach($bets as $bet) {
            if($bet->team_id == $winId) {
               if($result === 10) {
                  $bet->setResult($ratio[0] * $bet->summ, $result);
               }
               else {
                  $bet->setResult($ratio[1] * $bet->summ, $result);
               }
            }
            else {
               $bet->setResult(0, $result);
            }
         }
      }

      $this->result = $result;
      $this->save();
   }

   public function getRatio () {
      return array(
         round(100 / $this->ratio1, 2),
         round(100 / $this->ratio2, 2)
      );
   }
}