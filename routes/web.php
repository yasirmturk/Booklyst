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
// Static
Route::get('images/s/{filename}', 'Api\ImageController@showByFileName');
// Route::get('images/{image}', 'Api\ImageController@show')->name('show');
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
// All Routes
Route::get('routes', function () {
    $routeCollection = Route::getRoutes();

    echo "<table style='width:100%'>";
    echo "<tr>";
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='10%'><h4>Name</h4></td>";
    echo "<td width='70%'><h4>Corresponding Action</h4></td>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        echo "<tr>";
        echo "<td>" . $value->methods()[0] . "</td>";
        echo "<td>" . $value->uri() . "</td>";
        echo "<td>" . $value->getName() . "</td>";
        echo "<td>" . $value->getActionName() . "</td>";
        echo "</tr>";
    }
    echo "</table>";
});
