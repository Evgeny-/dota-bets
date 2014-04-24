@extends('layout')

@section('content')
<div id="admin">

   @include('admin.menu')

   <br>
   <h2>Список платежей</h2>

   <table class="users table">
      <tr>
         <th>id</th>
         <th>юзер</th>
         <th>сумма</th>
         <th>статус</th>
         <th>дата</th>
      </tr>
      @foreach($pays as $pay)
      <tr>
         <td>{{ $pay->id }}</td>
         <td>{{ $pay->user->name }}</td>
         <td>{{ $pay->summ }}</td>
         <td>{{ $pay->getStatus() }}</td>
         <td>{{ $pay->created_at }}</td>
      </tr>
      @endforeach
   </table>

   {{ $pays->links() }}
</div>
@stop