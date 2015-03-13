<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

/*
 * Horrible hack as Twitter::getUserTimeline is not available in
 * HomeController@index.
Route::get('/', function() {
  $tweets = Twitter::getUserTimeline(
    ['screen_name' => 'johnroberstorey', 'count' => 3, 'format' => 'json']
  );

  return App::make('App\Http\Controllers\HomeController')->index($tweets);
});
*/

Route::get('sponsors', 'SponsorsController@index');

Route::get('/tweets', function() {
  return Twitter::getUserTimeline(
    ['screen_name' => 'johnroberstorey',
  'count' => 3, 'format' => 'json']);
});

//App::make('menu')->put('sponsors', URL::route('page.sponsors'));
