@include('profile-menu')

<h2>Профиль</h2>

<table class="profile-table">
   <tr>
      <td class="image">
         <img src="{{ Auth::user()->image }}">
      </td>
      <td>
         <div class="name">{{ Auth::user()->name }}</div>
         <div class="summ">{{ Auth::user()->balance }}р на счету</div>
      </td>
   </tr>
</table>
