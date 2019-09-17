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

        Route::post('auth', ['as' => 'login', 'uses' => 'AuthController@login']);

    });

    // Route::group(['middleware' => [ 'jwt', 'jwt.auth']], function () {

    //     Route::group(['namespace' => 'Users'], function () {

    //         Route::get('users', ['as' => 'users.index', 'uses' => 'UserController@index']);

    //         Route::post('users', ['as' => 'users.store', 'uses' => 'UserController@store']);

    //         Route::get('users/{id}', ['as' => 'users.show', 'uses' => 'UserController@show']);

    //         Route::put('users/{id}', ['as' => 'users.update', 'uses' => 'UserController@update']);

    //         Route::delete('users/{id}', ['as' => 'users.destroy', 'uses' => 'UserController@destroy']);

    
    //     });
    // });


    
});
