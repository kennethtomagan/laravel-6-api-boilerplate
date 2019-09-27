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

Route::group(['prefix' => 'v1'], function () {

    Route::group(['namespace' => 'Auth'], function () {

        Route::post('auth/login', ['as' => 'login', 'uses' => 'AuthController@login']);

        Route::post('auth/register', ['as' => 'register', 'uses' => 'RegisterController@register']);
        // Send reset password mail
        Route::post('auth/recovery', 'ForgotPasswordController@sendPasswordResetLink');
        // handle reset password form process
        Route::post('auth/reset', 'ResetPasswordController@callResetPassword');

    });

    Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {

        Route::group(['namespace' => 'Profile'], function () {

            Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@me']);

            Route::put('profile', ['as' => 'profile', 'uses' => 'ProfileController@update']);

            Route::put('profile/password', ['as' => 'profile', 'uses' => 'ProfileController@updatePassword']);

        });

        Route::group(['namespace' => 'Auth'], function () {
    
            Route::post('logout', ['as' => 'logout', 'uses' => 'LogoutController@logout']);
    
        });

    });


    
});
