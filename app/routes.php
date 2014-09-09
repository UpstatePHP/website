<?php

Route::get('/', 'PageController@index');

Route::group(['prefix' => 'admin'], function()
{
    Route::resource('events', 'EventsAdminController');
    Route::resource('venues', 'VenuesAdminController');
});

Route::when('admin/*', 'admin');