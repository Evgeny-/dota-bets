<!DOCTYPE html>
<html>
<head>
   <meta http-equiv="content-type" content="text/html; charset=UTF-8">
   <meta charset="utf-8">
   <title>Ставки | Dota 2 - портал</title>
   <link rel="stylesheet" href="/css/bootstrap.min.css" media="screen, projection">
   <link rel="stylesheet" href="/css/style.css" media="screen, projection">
   <link rel="stylesheet" href="/css/main.css" media="screen, projection">
</head>
<body>
<div id="wrapper">
   <div class="wrapper">

      <div id="header">
         <a href="http://getdota2.ru/" id="logo">Dota 2 — портал</a>

         <ul id="nav">
            <li><a title="Сайт Dota 2" href="http://getdota2.ru/">Главная</a></li>
            <li class="current-menu-item"><a title="оставки на игры dota2" href="http://getdota2.ru/streams/">Стримы</a></li>
            <li><a title="обмен предметов вещей dota 2" href="http://getdota2.ru/obmen/">Обменник</a></li>
            <li><a title="Прайс вещей Dota 2, прайс предметов" href="http://getdota2.ru/price/">Прайс</a></li>
            <li><a title="Форум" href="http://getdota2.ru/forum/">Форум</a></li>
            <li><a title="Сувениры, подарки  Dota 2" href="http://getdota2.ru/gift/">Подарки</a></li>
            <li><a href="http://getdota2.ru/vacancy/">Вакансии</a></li>
            <li><a title="Стримы Dota 2" href="http://getdota2.ru/stream/">Стримы</a></li>
            <li><a title="Герои Dota 2" href="http://getdota2.ru/heroes/">Герои</a></li>
         </ul>
      </div>

      <div id="middle">

         <div id="container">
            <div id="content">
               @include('menu')
               @yield('content')
            </div>
         </div>

         <div id="sidebar">

            <div id="profile" class="bar">
               <div class="title">Профиль</div>
               <div class="content">
                  @if(Auth::check())
                     <table>
                        <tr>
                           <td><img class="avatar" src="{{ Auth::user()->image }}"></td>
                           <td>
                              <div class="name">{{ Auth::user()->name }}</div>
                              <div class="mute">{{ Auth::user()->balance }}р на счету</div>
                           </td>
                        </tr>
                     </table>
                  @else
                     <div class="join">Войди с помощью стима чтобы делать ставки!</div>
                     <div class="join-button">
                        <a href="/login">
                           <img src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_large_noborder.png">
                        </a>
                     </div>
                  @endif
               </div>
            </div>

            <div id="best" class="bar">
               <div class="title">Лучшие игроки</div>
               <div class="content">лалала</div>
            </div>

         </div>
      </div>
   </div>

</div>

<div id="footer">
   <noindex>
      Написать <a rel="nofollow" href="http://getdota2.ru/admin/">администратору</a> (Mail to <a rel="nofollow" href="http://getdota2.ru/admin/">admin</a>).
      При копировании материалов сайта, ссылка на Getdota2.ru - обязательна. @2011-2013г.
   </noindex>
</div>

</div>
<script src="/js/zepto.min.js"></script>
<script src="/js/moment.min.js"></script>
<script src="/js/main.js"></script>
</body>
</html>