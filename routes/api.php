<?php

use Illuminate\Support\Facades\Route;

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

// auth routes
Route::middleware('api.user')->group(function () {
    Route::post('login/social', 'AuthController@loginSocial')->name('login.social.api');
    Route::post('login/{provider}', 'AuthController@loginProvider')->name('login.provider.api');
    Route::post('login', 'AuthController@login')->name('login.api');
    Route::post('register', 'AuthController@register')->name('register.api');
});

// guest routes
Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail')->name('forgot.api');


// protected routes
Route::middleware('auth:api')->group(function () {
    Route::get('user', 'UserController@current');
    Route::post('logout', 'AuthController@logout')->name('logout.api');
    // Management
    Route::apiResource('users', 'UserController')->middleware('can:admin');
    Route::post('businesses', 'BusinessController@register')->name('api.business.register');
    Route::get('businesses/{id}', 'BusinessController@find')->name('api.business.find');
    Route::put('businesses/{id}', 'BusinessController@update')->name('api.business.update');
});
