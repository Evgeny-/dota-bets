@extends('layout')

@section('content')
<div id="admin">

   @include('admin.menu')

   <h2>Добавить турнир</h2>

   <form action="/admin/tourneys" method="POST" enctype="multipart/form-data">
      <div><input type="text" name="name" placeholder="Название турнира" required=""/></div>
      <div><input type="file" name="image"/> не обязательно</div>
      <div><textarea name="description" cols="40" rows="3" placeholder="Описание. Не обязательно"></textarea></div>
      <div><button class="btn btn-primary btn-big">Добавить турнир</button></div>
   </form>

   <h2>Список турниров</h2>

   <table class="tourneys">
      @foreach($tourneys as $t)
         <tr>
            <td class="img"><img src="/uploads/{{ $t->image }}"></td>
            <td>
               <div class="title">{{ $t->name }}</div>
               <div class="desc">{{ $t->description }}</div>
            </td>
            <td>{{ $t->created_at }}</td>
         </tr>
      @endforeach
   </table>

</div>
@stop