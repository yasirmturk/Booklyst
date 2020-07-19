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
Route::get('', 'Controller@index');
Route::get('ping', 'Controller@ping');
// Authentication
Auth::routes(['verify' => true]);
// Social login callbacks
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
// User Home
Route::get('home', 'HomeController@index')->middleware('auth')->name('home');
// User Developer
Route::get('developer', 'DeveloperController@index')->name('developer')->middleware('auth');
// Admin reset
Route::get('reset', 'Controller@reset')->middleware(['auth', 'can:admin'])->name('reset');
