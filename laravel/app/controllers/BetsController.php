<?php


class BetsController extends BaseController {

   public function postCreate () {
      if(!Auth::check()) {
         return "You are not authorized. Вы не авторизованы";
      }

      $user = Auth::user();
      $data = Input::all();
      $game = Game::find($data['game_id']);
      $team = Team::find($data['team_id']);

      if(!$team) {
         return "Team not found. Команда не найдена. P.S. не знаю что ты пытаешься сделать, но у тебя не выйдет :)";
      }

      if(!$game) {
         return "Unable to find a game. Игра не найдена.";
      }

      if((int) $game->result !== 0) {
         return "Game already started or finished. Игра уже началась или завершена.";
      }

      if(!is_numeric($data['summ'])) {
         return "Please enter a number money. Пожалуйста введите сумму числом в рублях.";
      }

      if((int) Auth::user()->balance < (int) $data['summ']) {
         return "Not enough money in the account. Недостаточно средств на счету.";
      }

      Bet::create(array(
         'user_id' => Auth::user()->id,
         'game_id' => $data['game_id'],
         'summ'    => (int) $data['summ'],
         'team_id' => $team->id
      ));

      $user->balance -= (int) $data['summ'];
      $user->save();

      return Redirect::back();
   }

}