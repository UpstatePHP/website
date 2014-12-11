<?php

// Filters
Route::when('admin/*', 'admin');

// Routes
Route::get('/', ['before' => 'cache', 'after' => 'cache', 'uses' => 'PageController@index']);

Route::get('login', ['as' => 'login', 'uses' => 'AuthController@showLogin']);
Route::post('login', ['as' => 'login.post', 'uses' => 'AuthController@login']);
Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

Route::group(['prefix' => 'admin', 'before' => 'auth'], function()
{
    Route::get('events', ['as' => 'admin.events.index', 'uses' => 'EventsController@adminIndex']);
    Route::get('events/create', ['as' => 'admin.events.create', 'uses' => 'EventsController@create']);
    Route::get('events/import', ['as' => 'admin.events.import', 'uses' => 'EventsController@import']);
    Route::post('events', ['as' => 'admin.events.store', 'uses' => 'EventsController@store']);
    Route::get('events/edit/{id}', ['as' => 'admin.events.edit', 'uses' => 'EventsController@edit']);
    Route::post('events/{id}', ['as' => 'admin.events.update', 'uses' => 'EventsController@update']);
    Route::get('events/delete/{id}', ['as' => 'admin.events.delete', 'uses' => 'EventsController@delete']);

    Route::get('venues', ['as' => 'admin.venues.index', 'uses' => 'VenuesController@adminIndex']);
    Route::get('venues/create', ['as' => 'admin.venues.create', 'uses' => 'VenuesController@create']);
    Route::post('venues', ['as' => 'admin.venues.store', 'uses' => 'VenuesController@store']);
    Route::get('venues/edit/{id}', ['as' => 'admin.venues.edit', 'uses' => 'VenuesController@edit']);
    Route::post('venues/{id}', ['as' => 'admin.venues.update', 'uses' => 'VenuesController@update']);
    Route::get('venues/delete/{id}', ['as' => 'admin.venues.delete', 'uses' => 'VenuesController@delete']);

    Route::get('sponsors', ['as' => 'admin.sponsors.index', 'uses' => 'SponsorsController@adminIndex']);
    Route::get('sponsors/create', ['as' => 'admin.sponsors.create', 'uses' => 'SponsorsController@create']);
    Route::post('sponsors', ['as' => 'admin.sponsors.store', 'uses' => 'SponsorsController@store']);
    Route::get('sponsors/edit/{id}', ['as' => 'admin.sponsors.edit', 'uses' => 'SponsorsController@edit']);
    Route::post('sponsors/{id}', ['as' => 'admin.sponsors.update', 'uses' => 'SponsorsController@update']);
    Route::get('sponsors/delete/{id}', ['as' => 'admin.sponsors.delete', 'uses' => 'SponsorsController@delete']);

});