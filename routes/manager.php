<?php

####### DASHBOARD ###################
Route::get('dashboard', [
    'as'   => 'manager.dashboard',
    'uses' => 'Manager\DashboardController@dashboard'
]);
Route::post('dashboard', [
    'as'   => 'manager.post.dashboard',
    'uses' => 'Manager\DashboardController@dashboard'
]);

####### LOCATIONS ###################
Route::get('locations', [
    'as'   => 'manager.location.index',
    'uses' => 'Manager\LocationController@index'
]);
Route::get('locations/{id}/edit', [
    'as'   => 'manager.location.edit',
    'uses' => 'Manager\LocationController@edit'
]);
Route::post('locations/{id}', [
    'as'   => 'manager.location.update',
    'uses' => 'Manager\LocationController@update'
]);
Route::get('locations/{id}/view', [
    'as'   => 'manager.location.view',
    'uses' => 'Manager\LocationController@view'
]);
Route::get('location/add', [
    'as'   => 'manager.location.add',
    'uses' => 'Manager\LocationController@add'
]);
Route::post('location/add', [
    'as'   => 'manager.location.store',
    'uses' => 'Manager\LocationController@store'
]);
Route::post('location/{id}/update-avatar', [
    'as'   => 'manager.location.image.update',
    'uses' => 'Manager\LocationController@updateImage'
]);
Route::post('location/delete', [
    'as'   => 'manager.location.delete',
    'uses' => 'Manager\LocationController@delete'
]);

####### DRINKS #######################
Route::get('drinks', [
    'as'   => 'manager.drink.index',
    'uses' => 'Manager\DrinkController@index'
]);
Route::post('drinks', [
    'as'   => 'manager.drink.post.index',
    'uses' => 'Manager\DrinkController@index'
]);
Route::get('drink/add', [
    'as'   => 'manager.drink.add',
    'uses' => 'Manager\DrinkController@add'
]);
Route::post('drink/add', [
    'as'   => 'manager.drink.store',
    'uses' => 'Manager\DrinkController@store'
]);
Route::get('drink/{id}/edit', [
    'as'   => 'manager.drink.edit',
    'uses' => 'Manager\DrinkController@edit'
]);
Route::post('drink/{id}/update', [
    'as'   => 'manager.drink.update',
    'uses' => 'Manager\DrinkController@update'
]);
Route::post('drink/delete', [
    'as'   => 'manager.drink.delete',
    'uses' => 'Manager\DrinkController@delete'
]);

####### COVER #########################
Route::get('cover', [
    'as'   => 'manager.cover.index',
    'uses' => 'Manager\CoverController@index'
]);
Route::post('cover', [
    'as'   => 'manager.cover.post.index',
    'uses' => 'Manager\CoverController@index'
]);
Route::get('cover/add', [
    'as'   => 'manager.cover.add',
    'uses' => 'Manager\CoverController@add'
]);
Route::post('cover/add', [
    'as'   => 'manager.cover.store',
    'uses' => 'Manager\CoverController@store'
]);
Route::get('cover/{id}/edit', [
    'as'   => 'manager.cover.edit',
    'uses' => 'Manager\CoverController@edit'
]);
Route::post('cover/{id}/update', [
    'as'   => 'manager.cover.update',
    'uses' => 'Manager\CoverController@update'
]);
Route::post('cover/delete', [
    'as'   => 'manager.cover.delete',
    'uses' => 'Manager\CoverController@delete'
]);

####### EVENT #########################
Route::get('event', [
    'as'   => 'manager.event.index',
    'uses' => 'Manager\EventController@index'
]);
Route::post('event', [
    'as'   => 'manager.event.post.index',
    'uses' => 'Manager\EventController@index'
]);
Route::get('event/add', [
    'as'   => 'manager.event.add',
    'uses' => 'Manager\EventController@add'
]);
Route::post('event/add', [
    'as'   => 'manager.event.store',
    'uses' => 'Manager\EventController@store'
]);
Route::get('event/{id}/edit', [
    'as'   => 'manager.event.edit',
    'uses' => 'Manager\EventController@edit'
]);
Route::post('event/{id}/update', [
    'as'   => 'manager.event.update',
    'uses' => 'Manager\EventController@update'
]);
Route::post('event/{id}/imageUpdate', [
    'as'   => 'manager.event.image.update',
    'uses' => 'Manager\EventController@imageUpdate'
]);
Route::post('event/delete', [
    'as'   => 'manager.event.delete',
    'uses' => 'Manager\EventController@delete'
]);

####### REPORTS #########################
Route::any('report', [
    'as'   => 'manager.report.index',
    'uses' => 'Manager\ReportController@index'
]);