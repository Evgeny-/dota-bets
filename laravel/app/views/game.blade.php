@extends('layout')

@section('content')

<div id="single-game">
   <h2>Информация о игре</h2>
   <table class="wrap-table">
      <tr>
         <td class="info">
            <ul>
               <li><b>Турнир:</b> {{ $game->tourney->name }}</li>
               <li><b>Начало:</b> {{ $game->getTime() }} {{ $game->getDate() }} (<span class="moment" time="{{ $game->start_at }}"></span>)</li>
               <li><b>Результат:</b> {{ $game->getResult() }}</li>
            </ul>
         </td>
         <td>
            <table class="table">
               <tr>
                  <td class="team team1">{{ $game->team1->name }} <img src="/uploads/{{ $game->team1->image }}"></td>

                  <td class="team team2"><img src="/uploads/{{ $game->team2->image }}"> {{ $game->team2->name }}</td>
               </tr>
               <tr>
                  <td class="team1">
                     <div class="total">игр {{ $game->team1->countGames() }}</div>
                     <div class="wins">побед ({{ $game->team1->getWinsRelative() }}%) {{ $game->team1->countWins() }}</div>
                     <div class="looses">поражений {{ $game->team1->countLooses() }}</div>
                  </td>

                  <td class="team2">
                     <div class="total">{{ $game->team2->countGames() }} игр</div>
                     <div class="wins">{{ $game->team2->countWins() }} ({{ $game->team2->getWinsRelative() }}%) побед</div>
                     <div class="looses">{{ $game->team2->countLooses() }} поражений</div>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
   </table>

   @if($game->result == 0)
      <h2>Сделать ставку</h2>
      @if(Auth::check())
         <form action="/bets/create" method="POST" class="form-inline bet-form">
            <input type="hidden" name="game_id" value="{{ $game->id }}"/>
            <select name="team_id">
               <option value="{{ $game->team1->id }}">{{ $game->team1->name }}</option>
               <option value="{{ $game->team2->id }}">{{ $game->team2->name }}</option>
            </select>
            <input type="text" class="summ" name="summ" placeholder="Сумма"/>
            <button class="btn">Поставить!</button>
            <a class="btn btn-link" href="/help">Нужна помощь?</a>
         </form>
      @else
         <div class="bet-form"><a href="/login">Войдите через steam</a>, чтобы сделать ставку!</div>
      @endif
   @endif

   @if(Auth::check() && count($myBets))
      <h2>Мои ставки на игру</h2>
      <table class="table table-bordered " style="margin: 10px auto;width: 80%">
         <tr>
            <th>Ставка на</th>
            <th>Сумма</th>
            <th>Выигрыш</th>
            <th>Дата</th>
         </tr>
         @foreach($myBets as $bet)
         <tr>
            <td>{{ $bet->team->name }}</td>
            <td>{{ $bet->summ }}</td>
            <td>{{ $bet->result_summ }}</td>
            <td><span time="{{ strtotime($bet->created_at) }}" class="moment"></span></td>
         </tr>
         @endforeach
      </table>
   @endif

   <h2>Предыдущие встречи команд</h2>

   @if( ($previous = $game->getPreviousGames()) && count($previous))
      <div class="games">
         @foreach($previous as $g)
            @include('single-game', array('game' => $g))
         @endforeach
      </div>
   @else
      <div class="bet-form">Игры не найдены</div>
   @endif
</div>

@stop