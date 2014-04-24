<?php

class PaysController extends BaseController {
   public function __construct() {
      $this->beforeFilter(function () {
         if(! Auth::check() || Auth::user()->admin != 1) {
            return Redirect::to('/');
         }
      });
   }

   public function postCreate () {
      $summ = Input::get('summ');

      if(!is_numeric($summ)) {
         die('Введите число');
      }

      $payment = Pay::create(array(
         'summ' => (int) $summ,
         'user_id' => Auth::user()->id,
         'status' => 0,
         'reason' => 'Пополнение счета'
      ));

      return $payment->payStart();
   }

   public function postBackPay () {
      $res = Input::all();

      if(!$res['webmoney']) die('Введите номер кошелька');
      if(!is_numeric($res['summ'])) die('Введите сумму в рублях');

      $summ = (int) $res['summ'];

      if($summ > Auth::user()->balance) die('Сумма которую вы указали привышает ваш баланс');
      if($summ < 100) die('Минимальная сумма для вывода средств 100 рублей.');

      Auth::user()->balance -= $summ;
      Auth::user()->save();

      Pay::create(array(
         'charge_id' => $res['webmoney'],
         'reason'    => $res['comment'],
         'summ'      => $summ,
         'user_id'   => Auth::user()->id,
         'is_back'   => 1
      ));

      return Redirect::back();
   }

   public function getResult () {
      $id = Input::get('charge_id');
      $event = null;

      try {
         $events = \Paysio\Event::all();
         foreach($events as $e) {
            if($e->data->id === $id) {
               $event = $e;
               break;
            }
         }
      }
      catch (\Exception $e) {
         return "Произошла ошибка. Свяжитесь с администратором<br>{$e->getMessage()}";
      }

      if($event === null) {
         return "Произошла ошибка. Свяжитесь с администратором";
      }

      $pay = Pay::where('charge_id', $event->data->id)->first();

      if( ! $pay) {
         return "Заказ на полполнение не найден";
      }

      if((int) $pay->status == 1) {
         return "Платеж уже выполнен";
      }

      if ($event->type == 'charge.success') {
         $pay->user->balance += $pay->summ;
         $pay->user->save();
         $pay->status = 1;
      }

      elseif ($event->type == 'charge.failure') {
         $pay->status = 2;
      }

      elseif ($event->type == 'charge.refund') {
         $pay->status = 3;
      }

      $pay->save();

      return Redirect::to('/profile/cashin');
   }
}