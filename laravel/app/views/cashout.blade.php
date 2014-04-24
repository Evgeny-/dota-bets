@extends('layout')

@section('content')

@include('mini-profile')

<h2>Вывод средств</h2>

<form action="/pays/back-pay" method="POST" style="margin: 15px 25px;">
   <div class="alert alert-info">
      Система ставок работает в режиме тестирования, поэтому вывод средств осуществляется вручную. <br>
      В данный момент вывод средств просходит только в системе <b>webmoney</b> на R кошелек. <br>
      Перевод средств происходит в течении 24 часов.
   </div>
   <div><input type="text" name="summ" placeholder="Сумма для вывода" required=""></div>
   <div><input type="text" name="webmoney" placeholder="R кошелек" required=""></div>
   <div>
      <textarea name="comment" rows="3" placeholder="Комментарий к плтежу, и контакты на всякий случай." style="width: 350px;"></textarea>
   </div>
   <div>
      <button class="btn">Отправить заявку</button>
   </div>
</form>

<h2>История вывода средств</h2>

@if(count($pays))
<table class="table">
   <tr>
      <th>сумма</th>
      <th>кошелек</th>
      <th>комментарий</th>
      <th>статус</th>
      <th>дата</th>
   </tr>
   @foreach($pays as $pay)
   <tr>
      <td>{{ $pay->summ }}</td>
      <td>{{ $pay->charge_id }}</td>
      <td>{{ $pay->reason }}</td>
      <td>{{ $pay->getStatus() }}</td>
      <td>{{ $pay->created_at }}</td>
   </tr>
   @endforeach
</table>
@else
<div style="margin: 15px 25px">Вы еще не выводили средства</div>
@endif

@stop