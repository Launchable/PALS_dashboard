<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    #return $request;
    return view('welcome');
});

Auth::routes();

#####################################
########### PROFILE ROUTE ###########
#####################################
Route::group([
    'middleware' => 'auth',
    'prefix'     => 'profile'
], function () {
    Route::get('/', [
        'as'   => 'profile',
        'uses' => 'ProfileController@edit'
    ]);
    Route::post('/', [
        'as'   => 'profile.update',
        'uses' => 'ProfileController@updateProfile'
    ]);
    Route::post('update-avatar', [
        'as'   => 'profile.avatar.update',
        'uses' => 'ProfileController@updateAvatar'
    ]);
    Route::post('update-password', [
        'as'   => 'profile.password.update',
        'uses' => 'ProfileController@updatePassword'
    ]);
});

######################################
######## SOCIAL LOGIN' S #############
######################################
Route::get('/social/redirect/{provider}', [
    'as'   => 'social.redirect',
    'uses' => 'Auth\SocialController@getSocialRedirect'
]);
Route::get('/social/handle/{provider}', [
    'as'   => 'social.handle',
    'uses' => 'Auth\SocialController@getSocialHandle'
]);



Route::get('sendFriendRequest', function() {

    $user = \App\User::find(3);
    $recipient = \App\User::find(14);

    $user->befriend($recipient);
});