<?php

####### DASHBOARD ###################
Route::get('dashboard', [
    'as'   => 'admin.dashboard',
    'uses' => 'Admin\DashboardController@dashboard'
]);

########### USERS ##################
Route::get('users', [
    'as'   => 'admin.user.index',
    'uses' => 'Admin\UserController@index'
]);
Route::post('users', [
    'as'   => 'admin.user.search',
    'uses' => 'Admin\UserController@search'
]);
Route::get('user/add', [
    'as'   => 'admin.user.add',
    'uses' => 'Admin\UserController@add'
]);
Route::post('user/add', [
    'as'   => 'admin.user.store',
    'uses' => 'Admin\UserController@store'
]);
Route::get('user/{id}/edit', [
    'as'   => 'admin.user.edit',
    'uses' => 'Admin\UserController@edit'
]);
Route::post('user/{id}/update-profile', [
    'as'   => 'admin.user.profile.update',
    'uses' => 'Admin\UserController@updateProfile'
]);
Route::post('user/{id}/update-password', [
    'as'   => 'admin.user.password.update',
    'uses' => 'Admin\UserController@updatePassword'
]);
Route::post('user/{id}/update-avatar', [
    'as'   => 'admin.user.avatar.update',
    'uses' => 'Admin\UserController@updateAvatar'
]);
Route::post('user/delete', [
    'as'   => 'admin.user.delete',
    'uses' => 'Admin\UserController@delete'
]);

####### LOCATIONS ###################
Route::get('locations', [
    'as'   => 'admin.location.index',
    'uses' => 'Admin\LocationController@index'
]);
Route::get('locations/{id}/edit', [
    'as'   => 'admin.location.edit',
    'uses' => 'Admin\LocationController@edit'
]);
Route::post('locations/{id}', [
    'as'   => 'admin.location.update',
    'uses' => 'Admin\LocationController@update'
]);
Route::get('locations/{id}/view', [
    'as'   => 'admin.location.view',
    'uses' => 'Admin\LocationController@view'
]);
Route::get('location/add', [
    'as'   => 'admin.location.add',
    'uses' => 'Admin\LocationController@add'
]);
Route::post('location/add', [
    'as'   => 'admin.location.store',
    'uses' => 'Admin\LocationController@store'
]);
Route::post('location/{id}/update-avatar', [
    'as'   => 'admin.location.image.update',
    'uses' => 'Admin\LocationController@updateImage'
]);
Route::post('location/delete', [
    'as'   => 'admin.location.delete',
    'uses' => 'Admin\LocationController@delete'
]);
Route::get('location/types', [
    'as'   => 'admin.location.types',
    'uses' => 'Admin\LocationTypeController@index'
]);

####### DRINKS #######################
Route::get('drinks', [
    'as'   => 'admin.drink.index',
    'uses' => 'Admin\DrinkController@index'
]);
Route::get('drink/add', [
    'as'   => 'admin.drink.add',
    'uses' => 'Admin\DrinkController@add'
]);
Route::post('drink/add', [
    'as'   => 'admin.drink.store',
    'uses' => 'Admin\DrinkController@store'
]);
Route::get('drink/{id}/edit', [
    'as'   => 'admin.drink.edit',
    'uses' => 'Admin\DrinkController@edit'
]);
Route::post('drink/{id}/update', [
    'as'   => 'admin.drink.update',
    'uses' => 'Admin\DrinkController@update'
]);
Route::post('drink/delete', [
    'as'   => 'admin.drink.delete',
    'uses' => 'Admin\DrinkController@delete'
]);
Route::get('drink/types', [
    'as'   => 'admin.drink.types',
    'uses' => 'Admin\DrinkTypeController@index'
]);

####### COVER #########################
Route::get('cover', [
    'as'   => 'admin.cover.index',
    'uses' => 'Admin\CoverController@index'
]);
Route::get('cover/add', [
    'as'   => 'admin.cover.add',
    'uses' => 'Admin\CoverController@add'
]);
Route::post('cover/add', [
    'as'   => 'admin.cover.store',
    'uses' => 'Admin\CoverController@store'
]);
Route::get('cover/{id}/edit', [
    'as'   => 'admin.cover.edit',
    'uses' => 'Admin\CoverController@edit'
]);
Route::post('cover/{id}/update', [
    'as'   => 'admin.cover.update',
    'uses' => 'Admin\CoverController@update'
]);
Route::post('cover/delete', [
    'as'   => 'admin.cover.delete',
    'uses' => 'Admin\CoverController@delete'
]);

####### EVENT #########################
Route::get('event', [
    'as'   => 'admin.event.index',
    'uses' => 'Admin\EventController@index'
]);
Route::get('event/add', [
    'as'   => 'admin.event.add',
    'uses' => 'Admin\EventController@add'
]);
Route::post('event/add', [
    'as'   => 'admin.event.store',
    'uses' => 'Admin\EventController@store'
]);
Route::get('event/{id}/edit', [
    'as'   => 'admin.event.edit',
    'uses' => 'Admin\EventController@edit'
]);
Route::post('event/{id}/update', [
    'as'   => 'admin.event.update',
    'uses' => 'Admin\EventController@update'
]);
Route::post('event/{id}/imageUpdate', [
    'as'   => 'admin.event.image.update',
    'uses' => 'Admin\EventController@imageUpdate'
]);
Route::post('event/delete', [
    'as'   => 'admin.event.delete',
    'uses' => 'Admin\EventController@delete'
]);

####### APP SETTING #########################
Route::get('app-setting', [
    'as'   => 'admin.setting.add',
    'uses' => 'Admin\AppController@add'
]);
Route::post('app-setting', [
    'as'   => 'admin.setting.store',
    'uses' => 'Admin\AppController@store'
]);

########################################################
################## AJAX ROUTES #########################
########################################################
Route::group(['prefix'     => 'ajax',
              'middleware' => 'isAjax'
], function () {

    ############## LOCATION TYPES ######################
    Route::get('location/types', [
        'as'   => 'ajax.administrator.location.types',
        'uses' => 'Admin\LocationTypeController@showTypes'
    ]);
    Route::post('location/types', [
        'as'   => 'ajax.administrator.location.add.type',
        'uses' => 'Admin\LocationTypeController@addType'
    ]);
    Route::post('location/type/edit', [
        'as'   => 'ajax.administrator.location.edit.type',
        'uses' => 'Admin\LocationTypeController@editType'
    ]);
    Route::post('location/type/update', [
        'as'   => 'ajax.administrator.location.update.type',
        'uses' => 'Admin\LocationTypeController@updateType'
    ]);
    Route::post('location/type/delete', [
        'as'   => 'ajax.administrator.location.delete.type',
        'uses' => 'Admin\LocationTypeController@deleteType'
    ]);

    ############## DRINK TYPES ######################
    Route::get('drink/types', [
        'as'   => 'ajax.administrator.drink.types',
        'uses' => 'Admin\DrinkTypeController@showTypes'
    ]);
    Route::post('drink/types', [
        'as'   => 'ajax.administrator.drink.add.type',
        'uses' => 'Admin\DrinkTypeController@addType'
    ]);
    Route::post('drink/type/edit', [
        'as'   => 'ajax.administrator.drink.edit.type',
        'uses' => 'Admin\DrinkTypeController@editType'
    ]);
    Route::post('drink/type/update', [
        'as'   => 'ajax.administrator.drink.update.type',
        'uses' => 'Admin\DrinkTypeController@updateType'
    ]);
    Route::post('drink/type/delete', [
        'as'   => 'ajax.administrator.drink.delete.type',
        'uses' => 'Admin\DrinkTypeController@deleteType'
    ]);

});


####### REPORTS #########################
Route::any('report', [
    'as'   => 'admin.report.index',
    'uses' => 'Admin\ReportController@index'
]);