<?php

class AdminController extends BaseController {
   public function __construct() {
      $this->beforeFilter(function () {
         if(! Auth::check() || Auth::user()->admin != 1) {
            return Redirect::to('/');
         }
      });
   }

   public function getIndex () {
      $pays = Pay::where('is_back', 1)->orderBy('id', 'desc')->paginate(10);

      return View::make('admin.index')
               ->with('pays', $pays);
   }

   public function postPayCashout () {
      $res = Input::all();

      $pay = Pay::find($res['id']);

      $pay->status = 1;
      $pay->save();

      return Redirect::back();
   }

   public function getBets () {
      $bets = Bet::orderBy('id', 'desc')->with('game', 'team')->paginate(30);

      return View::make('admin.bets')
               ->with('bets', $bets);
   }

   public function getGames () {
      $games = Game::with('team1', 'team2')->orderBy('id', 'desc')->paginate(30);
      $teams = Team::all();
      $tourneys = Tourney::orderBy('id', 'desc')->get();

      return View::make('admin.games')
               ->with('teams', $teams)
               ->with('games', $games)
               ->with('tourneys', $tourneys);
   }

   public function postGames () {
      $i = Input::all();
      $date = date_create_from_format('d/m/Y H:i', $i['date'].' '.$i['time']);

      if(!$date) {
         return "Time is not correct. Формат врмени или даты не верный";
      }

      $unix = date_format($date, 'U');

      if($unix < time()) {
         return "Time expiried. Время просрочено короче";
      }

      if($i['team1_id'] == $i['team2_id']) {
         return "Команды не могут буть одинаковыми";
      }

      if($i['ratio1'] + $i['ratio2'] !== 100) {
         return "Summ of ratio not equal 100. Сумма коэфф. не равна 100";
      }

      Game::create(array(
         'team1_id'   => $i['team1_id'],
         'team2_id'   => $i['team2_id'],
         'tourney_id' => $i['tourney_id'],
         'start_at'   => $unix,
         'ratio1'     => $i['ratio1'],
         'ratio2'     => $i['ratio2']
      ));

      return Redirect::back();
   }

   public function postSaveTimeGame ($id) {
      $game = Game::find($id);
      $i = Input::all();
      $date = date_create_from_format('d/m/Y H:i', $i['date'].' '.$i['time']);

      if(!$date) {
         return "Time is not correct. Формат врмени или даты не верный";
      }

      $unix = date_format($date, 'U');

      if($unix < time() + 60*30) {
         return "Time expiried. Время просрочено короче";
      }

      $game->start_at = $unix;
      $game->save();

      return Redirect::back();
   }

   public function postSaveResultGame ($id) {
      $game = Game::find($id);
      $game->setResult(Input::get('result'));

      return Redirect::back();
   }

   public function getUsers () {
      $users = User::orderBy('balance', 'desc')->paginate(30);

      return View::make('admin.users')
         ->with('users', $users);
   }

   public function getPays () {
      $pays = Pay::orderBy('id', 'desc')->paginate(30);

      return View::make('admin.pays')
         ->with('pays', $pays);
   }

   public function getTourneys () {
      $tourneys = Tourney::orderBy('id', 'desc')->get();

      return View::make('admin.tourneys')
               ->with('tourneys', $tourneys);
   }

   public function postTourneys () {
      $t = Input::all();
      $image = $this->uploadImage('image');

      Tourney::create(array(
         'name' => $t['name'],
         'image' => $image,
         'description' => $t['description']
      ));

      return Redirect::back();
   }

   public function getTeams () {
      $teams = Team::orderBy('id', 'desc')->get();

      return View::make('admin.teams')
               ->with('teams', $teams);
   }

   public function postTeams () {
      $t = Input::all();
      $image = $this->uploadImage('image');

      Team::create(array(
         'name' => $t['name'],
         'image' => $image
      ));

      return Redirect::back();
   }

   public function getLogs () {
      return View::make('admin.logs');
   }

   protected function uploadImage ($img) {
      if(!Input::hasFile($img)) return "";

      $image = Input::file($img);
      $name = rand(0, 10000) . '_' . time();
      $name .= '.' . $image->getClientOriginalExtension();
      $image->move('public/uploads', $name);

      return $name;
   }

}