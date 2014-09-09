<?php

Route::get('/', 'PageController@index');

Route::group(['prefix' => 'admin'], function()
{
    Route::resource('events', 'EventsAdminController');
});

Route::when('admin/*', 'admin');