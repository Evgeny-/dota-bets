<?php

class Pay extends Eloquent {
   protected $guarded = array();

   protected $statuses = array(
      0 => 'В ожидании',
      1 => 'Пополнено',
      2 => 'Ошибка пополнения',
      3 => 'Отмена пополнения'
   );

   protected $statusesBack = array(
      0 => 'В ожидании',
      1 => 'Исполнено',
      2 => 'Отмена. Деньги возвращенны'
   );

   public function payStart () {
      $charge = \Paysio\Charge::create(array(
         'amount' => $this->summ * 100, // сумма в копейках 100 руб
         'currency_id' => 'rur',
         'description' => 'Поплнение счета в системе ставок getDota2.ru',
         'success_url' => url() . '/pays/result',
         'failure_url' => url() . '/pays/result',
         'return_url'  => url() . '/pays/result'
      ));

      $this->charge_id = $charge->id;
      $this->save();

      return Redirect::to($charge->getResponse()->getLocation());
   }

   public function user () {
      return $this->belongsTo('user');
   }

   public function getStatus () {
      if($this->is_back == 0)
         return $this->statuses[$this->status];
      else
         return $this->statusesBack[$this->status];
   }
}