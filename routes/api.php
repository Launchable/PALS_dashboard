<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

###############################################
############# LOGIN CONTROLLER ################
###############################################
Route::post('login', 'Api\LoginController@login');
Route::post('logout', 'Api\LoginController@logout');

###############################################
############# REGISTER CONTROLLER #############
###############################################
Route::post('register', 'Api\RegisterController@register');
Route::post('password/reset', 'Api\RegisterController@sendResetLinkEmail');
Route::post('facebook/store', 'Api\RegisterController@postFacebookAPI');

###############################################
########### API ROUTES WITH MIDDLEWARE ############
###############################################
Route::group(['middleware' => 'auth:api'], function () {
    #########################################
    ############## PROFILE ##################
    #########################################
    Route::group(['prefix' => 'user'], function () {
        Route::post('location', 'Api\UserController@userLocation');
        Route::post('drinks', 'Api\DrinkController@userDrinks');
        Route::post('covers', 'Api\CoverController@userCovers');
        Route::get('account-detail', 'Api\UserController@getAccountDetail');
        Route::post('update-account', 'Api\UserController@updateAccountDetail');
        Route::get('order', 'Api\UserController@getUserOrder');

        Route::get('all', 'Api\UserController@getAllUsers');
    });
    #########################################
    ############## LOCATION #################
    #########################################
    Route::post('locations', 'Api\LocationController@locations');
    Route::post('location/events', 'Api\LocationController@eventsByLocationId');
    Route::post('location/drinks', 'Api\LocationController@drinksByLocation');

    ##########################################
    ############# FRIENDS ####################
    ##########################################
    Route::post('user/friends', 'Api\FriendController@getFriends');
    Route::post('friend/request', 'Api\FriendController@sendRequest');
    Route::post('friend/confirm', 'Api\FriendController@confirmRequest');
    Route::post('friend/decline', 'Api\FriendController@deleteRequest');

    #########################################
    ############## ORDER ##################
    #########################################
    Route::post('drink/order', 'Api\DrinkController@orderDrink');

    #########################################
    ############## Drinks / Covers ##################
    #########################################
    Route::post('drinks', 'Api\DrinkController@getAllDrinks');
    Route::post('covers', 'Api\DrinkController@getAllCovers');

    #########################################
    ############## REDEEM Drinks / Covers ##################
    #########################################
    Route::post('drink/redeem', 'Api\DrinkController@redeemDrink');

    ###############################################
    ############# APP SETTING #############
    ###############################################
    Route::post('app-setting', 'Api\AppController@getSetting');
    Route::post('app_settings/store', 'Api\RegisterController@postAppSettings');

    Route::post('payment/stripe', 'Api\UserController@postPaymentWithStripe');
    Route::post('register-device', 'Api\UserController@register_device');
});
