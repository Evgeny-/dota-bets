@extends('layout')

@section('content')
<div id="admin">

   @include('admin.menu')
   <br>
   <h2>Требуется оплатить</h2>

   <div class="alert alert-info">
      Пользователи которые хотят вывести свои деньги.
   </div>

   <table class="table">
      <tr>
         <th>юзер</th>
         <th>сумма</th>
         <th>кошелек</th>
         <th>комментарий</th>
         <th>дата</th>
         <th>управление</th>
      </tr>
      @foreach($pays as $pay)
      <tr>
         <td>{{ $pay->user->name }}</td>
         <td>{{ $pay->summ }}</td>
         <td>{{ $pay->charge_id }}</td>
         <td>{{ $pay->reason }}</td>
         <td>{{ $pay->created_at }}</td>
         <td>
            @if($pay->status == 0)
            <form action="/admin/pay-cashout" method="POST" class="form-inline">
               <input type="hidden" name="id" value="{{ $pay->id }}"/>
               <button class="btn btn-info" onclick="return confirm('Вы уверены, что хотите изменить статус заказу')">Исполнено</button>
            </form>
            @else
            {{ $pay->getStatus() }}
            @endif
         </td>
      </tr>
      @endforeach
   </table>

   {{ $pays->links() }}

</div>
@stop