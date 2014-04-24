<ul class="main-menu">
   <li><a href="/">Игры</a></li>

   @if(Auth::check())
      <li><a href="/profile">Профиль</a></li>
   @else
      <li><a href="/login">Вход</a></li>
   @endif

   <li><a href="/help">Помощь</a></li>

   @if(Auth::check() && Auth::user()->admin == 1)
      <li><a href="/admin">Админка</a></li>
   @endif

   @if(Auth::check())
      <li><a href="/logout">Выйти</a></li>
   @endif
</ul>