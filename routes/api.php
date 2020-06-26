<?php

use Illuminate\Http\Request;
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

Route::middleware(['cors', 'json.response'])->group(function () {

    // public routes
    Route::namespace('Auth')->group(function () {

        // auth routes
        Route::middleware('api.user')->group(function () {
            Route::post('login/social', 'ApiAuthController@loginSocial')->name('login.social.api');
            Route::post('login/{provider}', 'ApiAuthController@loginProvider')->name('login.provider.api');
            Route::post('login', 'ApiAuthController@login')->name('login.api');
            Route::post('register', 'ApiAuthController@register')->name('register.api');
        });

        // guest routes
        Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail')->name('forgot.api');
    });

    // protected routes
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', 'ApiAuthController@logout')->name('logout.api');
        Route::get('user', function (Request $request) {
            return $request->user();
        });
        Route::post('businesses', 'BusinessController@register')->name('api.business.register');
        Route::get('businesses/{id}', 'BusinessController@find')->name('api.business.find');
        Route::put('businesses/{id}', 'BusinessController@update')->name('api.business.update');
    });
});
