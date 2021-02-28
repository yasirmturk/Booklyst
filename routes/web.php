<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Root
Route::get('', 'Controller@welcome');
Route::get('ping', 'Controller@ping')->name('ping');
// All Routes
Route::get('routes', 'Controller@routes')->name('routes');
// Static
Route::get('images/s/{filename}', 'Api\ImageController@showByFileName');
// Route::get('images/{image}', 'Api\ImageController@show')->name('show');

// Authentication
Auth::routes(['verify' => true]);
// Social login callbacks
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

// Protected routes
Route::middleware('auth')->group(function () {
    // User Home
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::post('settings/update', 'SettingsController@update')->name('settings.update');
    // Stripe
    Route::name('stripe.')->prefix('stripe')->group(function () {
        Route::get('billing', 'StripeController@billing')->name('billing');
        Route::get('payment-methods', 'StripeController@paymentMethods')->name('payment-methods');
    });
    // User Developer
    Route::get('developer', 'DeveloperController@index')->name('developer');
    // Admin reset
    Route::get('reset', 'Controller@reset')->middleware(['can:admin'])->name('reset');
});
