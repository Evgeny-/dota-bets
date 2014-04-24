@extends('layout')

@section('content')

@include('mini-profile')

<h2>Мои ставки</h2>

@foreach($bets as $bet)
<div class="bet">
   <div class="info">
      {{ date('H:i d/m/Y', strtotime($bet->created_at)) }}
      (<span class="moment" time="{{ strtotime($bet->created_at) }}"></span>)
   </div>

   <table class="wrap-table">
      <tr>
         <td class="info">
            <ul>
               <li><b>Ставка на:</b> {{ $bet->team->name }}</li>
               <li><b>Результат игры:</b> {{ $bet->game->getResult() }}</li>
               <li><b>Сумма ставки:</b> {{ $bet->summ }}</li>
               <li><b>Выигрыш:</b> {{ $bet->result_summ }}</li>
            </ul>
         </td>
         <td>
            <table class="table game" onclick="location='/games/game/{{ $bet->game_id }}'">
               <tr>
                  <td class="team team1">
                     {{ $bet->game->team1->name }}
                     <img src="/uploads/{{ $bet->game->team1->image }}">
                  </td>
                  <td class="team team2">
                     <img src="/uploads/{{ $bet->game->team2->image }}">
                     {{ $bet->game->team2->name }}
                  </td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
</div>
@endforeach

{{ $bets->links() }}

@stop