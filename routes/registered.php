<?php

######### HOME ##################################
Route::get('/', [
    'as'   => 'registered.home',
    'uses' => 'Registered\HomeController@index'
]);

######### HISTORY ###############################
Route::get('history', [
    'as'   => 'registered.history',
    'uses' => 'Registered\HistoryController@index'
]);

######### FRIENDS ###############################
Route::group([
    'middleware' => 'auth',
    'prefix'     => 'friends'
], function () {

    Route::get('/', [
        'as'   => 'registered.friends',
        'uses' => 'Registered\FriendController@index'
    ]);


});

######### AJAX FRIENDS ##########################
Route::group([
    'middleware' => 'auth',
    'prefix'     => 'friend'
], function () {

    // Request
    Route::post('confirmRequest', [
        'as'   => 'ajax.friend.confirmRequest',
        'uses' => 'Registered\AjaxFriendController@confirmRequest'
    ]);
    Route::post('deleteRequest', [
        'as'   => 'ajax.friend.deleteRequest',
        'uses' => 'Registered\AjaxFriendController@deleteRequest'
    ]);
    
});