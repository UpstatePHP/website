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

Route::get('/', ['as' => 'page.index', 'uses' => 'PagesController@index']);
Route::get('sponsors', ['as' => 'page.sponsors', 'uses' => 'PagesController@sponsors']);

Route::get('/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@login']);
Route::post('/login', ['as' => 'auth.login.do', 'uses' => 'Auth\AuthController@doLogin']);
Route::get('/logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);

Route::group(
    [
        'prefix' => 'admin',
        'middleware' => ['backend', 'auth'],
        'namespace' => 'Backend'
    ],
    function()
    {
        Route::get('/', function()
        {
            return Redirect::route('admin.dashboard');
        });
        Route::get('/dashboard', ['as' => 'admin.dashboard', 'uses' => 'DashboardController@dashboard']);

        Route::get('events', ['as' => 'admin.events.index', 'uses' => 'EventsController@index']);
        Route::get('events/create', ['as' => 'admin.events.create', 'uses' => 'EventsController@create']);
        Route::get('events/import', ['as' => 'admin.events.import', 'uses' => 'EventsController@import']);
        Route::post('events', ['as' => 'admin.events.store', 'uses' => 'EventsController@store']);
        Route::get('events/edit/{id}', ['as' => 'admin.events.edit', 'uses' => 'EventsController@edit']);
        Route::post('events/{id}', ['as' => 'admin.events.update', 'uses' => 'EventsController@update']);
        Route::get('events/delete/{id}', ['as' => 'admin.events.delete', 'uses' => 'EventsController@delete']);

        Route::get('sponsors', ['as' => 'admin.sponsors.index', 'uses' => 'SponsorsController@index']);
        Route::get('sponsors/create', ['as' => 'admin.sponsors.create', 'uses' => 'SponsorsController@create']);
        Route::post('sponsors', ['as' => 'admin.sponsors.store', 'uses' => 'SponsorsController@store']);
        Route::get('sponsors/edit/{id}', ['as' => 'admin.sponsors.edit', 'uses' => 'SponsorsController@edit']);
        Route::post('sponsors/{id}', ['as' => 'admin.sponsors.update', 'uses' => 'SponsorsController@update']);
        Route::get('sponsors/delete/{id}', ['as' => 'admin.sponsors.delete', 'uses' => 'SponsorsController@delete']);

        Route::get('pages', ['as' => 'admin.pages.index', 'uses' => 'PagesController@index']);
        Route::get('pages/create', ['as' => 'admin.pages.create', 'uses' => 'PagesController@create']);
        Route::post('pages', ['as' => 'admin.pages.store', 'uses' => 'PagesController@store']);
        Route::get('pages/edit/{id}', ['as' => 'admin.pages.edit', 'uses' => 'PagesController@edit']);
        Route::post('pages/{id}', ['as' => 'admin.pages.update', 'uses' => 'PagesController@update']);
        Route::get('pages/delete/{id}', ['as' => 'admin.pages.delete', 'uses' => 'PagesController@delete']);

    }
);

Route::get('{path?}', 'PagesController@catchAll')->where('path', '.+');
