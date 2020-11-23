<?php

use App\Models\Business;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application.
|
*/

Route::get('', 'AdminController@index')->name('index');
// Users
Route::resource('users', 'UserController')->only(['index', 'store', 'destroy']);
Route::model('user', User::class);
Route::resource('users.businesses', 'UserBusinessController')->shallow()->only(['index', 'show']);
// Businesses
Route::resource('businesses', 'BusinessController')->only(['index', 'store', 'destroy']);
Route::model('business', Business::class);
Route::resource('businesses.products', 'BusinessProductController')->shallow()->only(['index', 'show']);
Route::resource('businesses.services', 'BusinessServiceController')->shallow()->only(['index', 'show']);
Route::resource('products', 'ProductController')->only(['index', 'store', 'destroy']);
Route::resource('services', 'ServiceController')->only(['index', 'store', 'destroy']);
// Settings
Route::name('settings.')->prefix('settings')->group(function () {
    Route::resource('categories', 'CategoryController')->only(['index', 'store', 'destroy']);
});
