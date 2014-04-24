@extends('layout')

@section('content')

@include('mini-profile')

<h2>Пополнить счет</h2>

<form action="/pays/create" method="POST" class="form-inline bet-form" style="margin: 15px 25px">
   <input type="text" name="summ" placeholder="Сумма поплнения в рублях">
   <button class="btn">Пополнить</button>
   <a class="btn btn-link" href="/help">Нужна помощь?</a>
</form>
<br>
<h2>История поплнения счета</h2>

@if(count($pays))
<table class="table">
   <tr>
      <th>#</th>
      <th>Сумма</th>
      <th>Статус</th>
      <th>Дата</th>
   </tr>
   @foreach($pays as $pay)
   <tr>
      <td>{{ $pay->id }}</td>
      <td>{{ $pay->summ }}</td>
      <td>{{ $pay->getStatus() }}</td>
      <td>{{ $pay->created_at }}</td>
   </tr>
   @endforeach
</table>
@else
<div style="margin: 15px 25px">Вы еще не пополняли свой счет.</div>
@endif

@stop