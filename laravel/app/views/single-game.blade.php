<div class="game">
   <div class="info">
      <span class="moment left" time="{{ $game->start_at }}"></span>
      <span class="tourney right">{{ $game->tourney->name }}</span>
      <div class="clear"></div>
   </div>
   <table class="games-table" onclick="location='/games/game/{{ $game->id }}'">
      <tr>
         <td class="team team1">
            <div class="name">
               {{ $game->team1->name }}
               <div class="ratio">{{ $game->ratio1 }}%</div>
            </div>
            <img src="/uploads/{{ $game->team1->image }}">
         </td>

         <td class="vs">
            @if($game->result == 10)
               <b>></b>
            @elseif($game->result == 20)
               <b><</b>
            @else
               vs
            @endif
         </td>

         <td class="team team2">
            <img src="/uploads/{{ $game->team2->image }}">
            <div class="name">
               {{ $game->team2->name }}
               <div class="ratio">{{ $game->ratio2 }}%</div>
            </div>
         </td>

         <td class="tourney">
            <div class="img-wrap" style="background-image: url('/uploads/{{ $game->tourney->image }}')"></div>
         </td>
      </tr>
   </table>
</div>