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

Route::get('sponsors', 'SponsorsController@index');

Route::group(
    [
        'prefix' => 'admin',
        'middleware' => 'backend'
    ],
    function()
    {
        Route::get('/', 'BackendController@dashboard');
        Route::get('/dashboard', 'BackendController@dashboard');
    }
);