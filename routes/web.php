<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('login', 'Auth\AuthController@getLogin')->name('login');
Route::post('login', 'Auth\AuthController@postLogin');
Route::post('logout', 'Auth\AuthController@logout')->name('logout');

Route::group(['middleware' => ['checkcookie']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('status', 'StatusController', ['only' => [
        'index', 'show'
    ]]);
    Route::get('changepass', 'Auth\PasswordController@changePass')->name('password.change');
    Route::post('changepass', 'Auth\PasswordController@postChangePass')->name('password.postchange');
    Route::group(['middleware' => ['requireadmin'], 'as' => 'admin.'], function() {
        Route::get('admin', 'Admin\AdminController@index')->name('home');
        Route::put('admin/users/{user}/reset', 'Admin\UserController@resetPassword')->name('users.resetpassword');
        Route::resource('admin/users', 'Admin\UserController');
        Route::resource('admin/services', 'Admin\ServiceController');
    });
});


Route::group(['middleware' => ['checkheader']], function() {
    Route::get('auth', function() {
        abort(403, "You are not welcome");
    })->name('check');
});