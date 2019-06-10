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

    // Common routes

    Route::get('common/users', 'Common\ReferenceController@getUsers')->name('common.reference.users');

    // User notification routes

    Route::get('usernotifications', 'Common\UserNotificationController@index')->name('usernotifications.index');
    Route::get('usernotifications/indexdata', 'Common\UserNotificationController@getUserNotifications')->name('usernotifications.indexdata');
    Route::get('usernotifications/{notification_id}', 'Common\UserNotificationController@show')->name('usernotifications.show');

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

        // roles routes

        Route::get('roles', 'Admin\RoleController@index')->name('roles.index');
        Route::get('roles/indexdata', 'Admin\RoleController@getRoles')->name('roles.indexdata');

        Route::get('roles/create', 'Admin\RoleController@create')->name('roles.create');
        Route::get('roles/{role_id}', 'Admin\RoleController@show')->name('roles.show');
        Route::get('roles/{role_id}/edit', 'Admin\RoleController@edit')->name('roles.edit');

        Route::post('roles', 'Admin\RoleController@store')->name('roles.store');

        Route::put('roles/{role_id}', 'Admin\RoleController@update')->name('roles.update');

        Route::delete('roles/{role_id}', 'Admin\RoleController@destroy')->name('roles.destroy');

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

        // VUE invoices example

        Route::get('vueinvoices/create', 'Example\VueInvoiceController@create')->name('vueinvoices.create');
        Route::get('vueinvoices/{invoice_id}/edit', 'Example\VueInvoiceController@edit')->name('vueinvoices.edit');

        Route::post('vueinvoices', 'Example\VueInvoiceController@store')->name('vueinvoices.store');

        Route::put('vueinvoices/{invoice_id}', 'Example\VueInvoiceController@update')->name('vueinvoices.update');

        Route::delete('vueinvoices/{invoice_id}', 'Example\VueInvoiceController@destroy')->name('vueinvoices.destroy');

        // upload forms example

        Route::get('uploadforms/create', 'Example\UploadFormController@create')->name('uploadforms.create');
        Route::get('uploadforms/{upload_id}/edit', 'Example\UploadFormController@edit')->name('uploadforms.edit');
        Route::post('uploadforms', 'Example\UploadFormController@store')->name('uploadforms.store');
        Route::put('uploadforms/{upload_id}', 'Example\UploadFormController@update')->name('uploadforms.update');

        // vue laravel pagination example

        Route::get('vuepaginations/index', 'Example\VuePaginationController@index')->name('vuepaginations.index');
        Route::get('vuepaginations/usersdata', 'Example\VuePaginationController@getUsers')->name('vuepaginations.usersdata');

    });

});

