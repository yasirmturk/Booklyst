<?php

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
Route::resource('users', 'UserController')->only(['index', 'store', 'destroy']);
Route::resource('businesses', 'BusinessController')->only(['index', 'store', 'destroy']);
Route::resource('products', 'ProductController')->only(['index', 'store', 'destroy']);
Route::resource('services', 'ServiceController')->only(['index', 'store', 'destroy']);
Route::name('settings.')->prefix('settings')->group(function () {
    Route::resource('categories', 'CategoryController')->only(['index', 'store', 'destroy']);
});
