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

// Base routes

Route::middleware('auth')->group(function () {

    Route::get('dashboard', 'Dashboard')->name('dashboard');

    // Administrator routes

    Route::prefix('admin')->name('admin.')->group(function () {

        // users routes

        Route::get('users', 'Admin\UserController@index')->name('users.index');
        Route::get('users/datatables', 'Admin\UserController@dataTables')->name('users.datatables');

        Route::get('users/create', 'Admin\UserController@create')->name('users.create');
        Route::get('users/{user_id}', 'Admin\UserController@show')->name('users.show');
        Route::get('users/{user_id}/edit', 'Admin\UserController@edit')->name('users.edit');

        Route::post('users', 'Admin\UserController@store')->name('users.store');

        Route::put('users/{user_id}', 'Admin\UserController@update')->name('users.update');

        Route::delete('users/{user_id}', 'Admin\UserController@destroy')->name('users.destroy');

    });

});

