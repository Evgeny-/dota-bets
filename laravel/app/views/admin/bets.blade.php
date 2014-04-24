@extends('layout')

@section('content')
<div id="admin">

   @include('admin.menu')

   <br><h2>Список ставок</h2>

   <table class="table">
      <tr>
         <th>Пользователь</th>
         <th>Игра</th>
         <th>Ставка</th>
         <th>Сумма</th>
         <th>Выигрыш</th>
         <th>Результат</th>
      </tr>
      @foreach($bets as $bet)
      <tr>
         <td>{{ $bet->user->name }}</td>
         <td><a href="/games/game/{{ $bet->game_id }}">{{ $bet->game->team1->name }} vs {{ $bet->game->team2->name }}</a></td>
         <td>{{ $bet->team->name }}</td>
         <td>{{ $bet->summ }}</td>
         <td>{{ $bet->result_summ }}</td>
         <td>{{ $bet->game->getResult() }}</td>
      </tr>
      @endforeach
   </table>
   {{ $bets->links() }}
</div>
@stop