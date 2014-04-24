<?php


Route::controller('/games', 'GamesController');
Route::controller('/admin', 'AdminController');
Route::controller('/bets', 'BetsController');
Route::controller('/profile', 'ProfileController');
Route::controller('/pays', 'PaysController');


Route::get('/', 'GamesController@getIndex');
Route::get('/login', 'HomeController@getLogin');
Route::get('/join', 'HomeController@getJoin');
Route::get('/logout', 'HomeController@getLogout');
Route::get('/help', 'HomeController@getHelp');