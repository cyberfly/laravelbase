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

    // Upload routes

    Route::post('uploads/{collection_name}', 'UploadController@store')->name('uploads.store');
    Route::delete('uploads/{attachment_id}', 'UploadController@destroy')->name('uploads.destroy');

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

    // Example routes

    Route::prefix('examples')->name('examples.')->group(function () {

        // multi forms example

        Route::get('multiforms/create', 'Example\MultiFormController@create')->name('multiforms.create');
        Route::post('multiforms', 'Example\MultiFormController@store')->name('multiforms.store');

        // invoices example

        Route::get('invoices/create', 'Example\InvoiceController@create')->name('invoices.create');
        Route::get('invoices/{invoice_id}/edit', 'Example\InvoiceController@edit')->name('invoices.edit');

        Route::post('invoices', 'Example\InvoiceController@store')->name('invoices.store');

        Route::put('invoices/{invoice_id}', 'Example\InvoiceController@update')->name('invoices.update');

        Route::delete('invoices/{invoice_id}', 'Example\InvoiceController@destroy')->name('invoices.destroy');

        //
    });

});

