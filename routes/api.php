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
Route::name('login.')->middleware('api.user')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('login/social', 'AuthController@loginSocial')->name('social');
    Route::post('login/{provider}', 'AuthController@loginProvider')->name('provider');
    Route::post('register', 'AuthController@register')->name('register');
});

// Guest routes
Route::name('meta.')->prefix('meta')->middleware('client')->group(function () {
    Route::get('', 'MetaController@default');
    Route::get('all', 'MetaController@all')->name('all');
});
Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail')->name('forgot');

// Protected routes
Route::middleware('auth:api')->group(function () {
    // User profile
    Route::get('user', 'UserController@current');
    // Logout
    Route::post('logout', 'AuthController@logout')->name('logout');
    // Management
    Route::apiResource('users', 'UserController')->middleware('can:admin');
    // Business
    Route::name('business.')->group(function () {
        Route::post('businesses', 'BusinessController@register')->name('register');
        Route::get('businesses', 'BusinessController@mine')->name('mine');
        Route::get('businesses/{id}', 'BusinessController@find')->name('find');
        Route::put('businesses/{id}', 'BusinessController@update')->name('update');
    });
    // Image
    Route::name('images.')->group(function () {
        Route::post('images', 'ImageController@store')->name('store');
        Route::post('images/update/{filename}', 'ImageController@update')->name('update');
        Route::get('images/f/{filename}', 'ImageController@showByFileName')->name('show');
    });
    // Search
    Route::name('search.')->prefix('search')->group(function () {
        Route::get('categories', 'SearchController@listCategories')->name('listCategories');
    });
});
