@extends('layout')

@section('content')
<div id="admin">

   @include('admin.menu')

   <h2>Добавить команду</h2>

   <form action="/admin/teams" method="POST" enctype="multipart/form-data">
      <div><input type="text" name="name" placeholder="Название команды" required=""/></div>
      <div><input type="file" name="image"/></div>
      <div><button class="btn btn-primary btn-big">Добавить команду</button></div>
   </form>

   <h2>Список команд</h2>

   <table class="teams">
      @foreach($teams as $t)
      <tr>
         <td class="img"><img src="/uploads/{{ $t->image }}"></td>
         <td>
            <div class="title">{{ $t->name }}</div>
         </td>
         <td>{{ $t->created_at }}</td>
      </tr>
      @endforeach
   </table>
</div>
@stop