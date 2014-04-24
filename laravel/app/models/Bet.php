<?php

class Bet extends Eloquent {
   protected $guarded = array();

   public function user () {
      return $this->belongsTo('User');
   }

   public function game () {
      return $this->belongsTo('Game');
   }

   public function team () {
      return $this->belongsTo('Team');
   }

   public function setResult ($summ, $res) {
      $this->result_summ = $summ;
      $this->result = $res;
      $this->save();

      $this->user->balance += $summ;
      $this->user->save();
   }
}