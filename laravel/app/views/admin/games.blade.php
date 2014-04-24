@extends('layout')

@section('content')
<div id="admin">

   @include('admin.menu')

   <h2>Добавить игру</h2>

   <form action="/admin/games" method="POST" enctype="multipart/form-data">
      <div>
         <select name="tourney_id">
            @foreach($tourneys as $t)
            <option value="{{ $t->id }}">{{ $t->name }}</option>
            @endforeach
         </select>
      </div>
      <div>
         <select name="team1_id" id="">
            @foreach($teams as $team)
            <option value="{{ $team->id }}">{{ $team->name }}</option>
            @endforeach
         </select>
         <select name="team2_id">
            @foreach($teams as $team)
            <option value="{{ $team->id }}">{{ $team->name }}</option>
            @endforeach
         </select>
      </div>

      <div>
         <table>
            <tr>
               <td><div id="ratio1"></div></td>
               <td><div id="ratio2"></div></td>
            </tr>
            <tr>
               <td><input type="text" name="ratio1" placeholder="Коэфф. первой команды" required>&nbsp;</td>
               <td><input type="text" name="ratio2" placeholder="второй команды" required> (в процентах или дробью)</td>
            </tr>
         </table>
      </div>

      <div>
         <input type="text" name="time" placeholder="время HH:MM" required>
         <input type="text" name="date" placeholder="дата DD/MM/YYYY" required> (по Москве)
      </div>
      <button class="btn btn-primary btn-big">Добавить игру</button>
   </form>

   <h2>Список игр</h2>

   <table class="games table">
      <tr>
         <th>турнир</th>
         <th>команда 1</th>
         <th></th>
         <th>команда 2</th>
         <th>начало</th>
         <th>статус</th>
      </tr>
      @foreach($games as $g)
      <tr>
         <td>
            <b>{{ Tourney::find($g->tourney_id)->name }}:</b>
         </td>
         <td>
            {{ $g->team1->name }}
         </td>
         <td>
            @if($g->result == 10)
               <b>></b>
            @elseif($g->result == 20)
               <b><</b>
            @else
               vs.
            @endif
         </td>
         <td>
            {{ $g->team2->name }}
         </td>
         <td>
            @if($g->result == 0)
               <form action="/admin/save-time-game/{{ $g->id }}" method="POST" class="form-inline">
                  <input type="text" name="time" value="{{ $g->getTime() }}">
                  <input type="text" name="date" value="{{ $g->getDate() }}">
                  <button onclick="return confirm('Изменить игре {{ $g->team1->name }} vs {{ $g->team2->name }} дату?')" class="btn btn-info">s</button>
               </form>
            @else
               {{ $g->getTime() }} {{ $g->getDate() }}
            @endif
         </td>

         <td>
            @if($g->result == 0 || $g->result == 1)
               <form action="/admin/save-result-game/{{ $g->id }}" method="POST" class="form-inline">
                  <select name="result">
                     <option value="0">Еще не началось</option>
                     <option value="1" <?if($g->result==1){?>selected=""<?}?>>Началось</option>
                     <option value="2">Игра отменена</option>
                     <option value="3">Игра забракована</option>
                     <option value="4">Ничья</option>
                     <option value="10">{{ $g->team1->name }}</option>
                     <option value="20">{{ $g->team2->name }}</option>
                  </select>
                  <button onclick="return confirm('Выставить игре {{ $g->team1->name }} vs {{ $g->team2->name }} результат?')" class="btn btn-info">s</button>
               </form>
            @else
               {{ $g->getResult() }}
            @endif
         </td>
      </tr>
      @endforeach
   </table>

   {{ $games->links() }}
</div>
@stop