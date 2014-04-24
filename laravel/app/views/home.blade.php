@extends('layout')

@section('content')

@if(count($newGames))
   <h2>Будущие игры</h2>
   <div class="games">
      @foreach($newGames as $game)
         @include('single-game', array('game' => $game))
      @endforeach
   </div>
@endif

@if(count($startedGames))
   <h2>Текущие игры</h2>
   <div class="games">
      @foreach($startedGames as $game)
         @include('single-game', array('game' => $game))
      @endforeach
   </div>
@endif

@if(count($otherGames))
   <h2>Прошедшие игры</h2>
   <div class="games">
      @foreach($otherGames as $game)
         @include('single-game', array('game' => $game))
      @endforeach

      {{ $otherGames->links() }}
   </div>
@endif

@stop