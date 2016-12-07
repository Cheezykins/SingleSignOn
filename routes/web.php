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
    Route::get('changepass', 'Auth\PasswordController@changePass')->name('password.change');
    Route::post('changepass', 'Auth\PasswordController@postChangePass')->name('password.postchange');
    Route::group(['middleware' => ['requireadmin'], 'as' => 'admin.'], function() {
        Route::get('admin', 'Admin\AdminController@index')->name('home');
        Route::resource('admin/users', 'Admin\UserController');
    });
});


Route::group(['middleware' => ['checkheader']], function() {
    Route::get('/auth', 'HomeController@check')->name('check');
});