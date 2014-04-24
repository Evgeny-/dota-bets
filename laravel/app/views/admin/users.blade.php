@extends('layout')

@section('content')
<div id="admin">

   @include('admin.menu')

   <br>
   <h2>Список пользователей</h2>

   <table class="users table">
      <tr>
         <th>id</th>
         <th>аватар</th>
         <th>логин</th>
         <th>баланс</th>
         <th>дата реги</th>
      </tr>
      @foreach($users as $u)
      <tr>
         <td>{{ $u->id }}</td>
         <td class="img"><img src="{{ $u->image }}"></td>
         <td>{{ $u->name }}</td>
         <td>{{ $u->balance }}р.</td>
         <td>{{ $u->created_at }}</td>
      </tr>
      @endforeach
   </table>

   {{ $users->links() }}
</div>
@stop