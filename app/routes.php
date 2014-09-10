<?php

// Filters
Route::when('admin/*', 'admin');

// Routes
Route::get('/', 'PageController@index');

Route::group(['prefix' => 'admin'], function()
{
    Route::get('events', ['as' => 'admin.events.index', 'uses' => 'EventsController@adminIndex']);
    Route::get('events/create', ['as' => 'admin.events.create', 'uses' => 'EventsController@create']);
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

    Route::get('organizations', ['as' => 'admin.organizations.index', 'uses' => 'OrganizationsController@adminIndex']);
    Route::get('organizations/create', ['as' => 'admin.organizations.create', 'uses' => 'OrganizationsController@create']);
    Route::post('organizations', ['as' => 'admin.organizations.store', 'uses' => 'OrganizationsController@store']);
    Route::get('organizations/edit/{id}', ['as' => 'admin.organizations.edit', 'uses' => 'OrganizationsController@edit']);
    Route::post('organizations/{id}', ['as' => 'admin.organizations.update', 'uses' => 'OrganizationsController@update']);
    Route::get('organizations/delete/{id}', ['as' => 'admin.organizations.delete', 'uses' => 'OrganizationsController@delete']);

});