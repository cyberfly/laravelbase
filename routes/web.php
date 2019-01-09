<?php

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

Route::get('/', 'Dashboard')->middleware('auth');

// Example Routes
Route::view('/examples/plugin', 'examples.plugin');
Route::view('/examples/blank', 'examples.blank');

// Laravel Auth routes

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Base routes

Route::middleware('auth')->group(function () {

    Route::get('dashboard', 'Dashboard')->name('dashboard');

});

