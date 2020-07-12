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

Route::get('', 'AdminController@index');
Route::name('settings.')->prefix('settings')->group(function () {
    Route::resource('categories', 'CategoryController')->only(['index', 'store', 'destroy']);
    // Route::get('category', 'CategoryController@index')->name('category');
});
