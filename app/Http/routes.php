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
        'middleware' => 'backend',
        'namespace' => 'Backend'
    ],
    function()
    {
        Route::get('/', 'DashboardController@dashboard');
        Route::get('/dashboard', 'DashboardController@dashboard');

        Route::get('events', ['as' => 'admin.events.index', 'uses' => 'EventsController@index']);
        Route::get('events/create', ['as' => 'admin.events.create', 'uses' => 'EventsController@create']);
        Route::get('events/import', ['as' => 'admin.events.import', 'uses' => 'EventsController@import']);
        Route::post('events', ['as' => 'admin.events.store', 'uses' => 'EventsController@store']);
        Route::get('events/edit/{id}', ['as' => 'admin.events.edit', 'uses' => 'EventsController@edit']);
        Route::post('events/{id}', ['as' => 'admin.events.update', 'uses' => 'EventsController@update']);
        Route::get('events/delete/{id}', ['as' => 'admin.events.delete', 'uses' => 'EventsController@delete']);

    }
);