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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['cors', 'json.response']], function () {
    // public routes
    Route::post('/login/social', 'Auth\ApiAuthController@socialLogin')->name('login.social.api')->middleware('api.user');
    Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api')->middleware('api.user');
    Route::post('/register','Auth\ApiAuthController@register')->name('register.api')->middleware('api.user');
    Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');

    Route::middleware('auth:api')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});
