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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('profile', 'UserController@show')->middleware('auth')->name('profile.show');
Route::post('profile', 'UserController@update')->middleware('auth')->name('profile.update');

Route::resource('sounds', 'SoundsController');

Route::get('audio', 'SoundsController@index')->middleware('auth')->name('sounds.index');

Route::get('audio-upload', 'SoundsController@create')->middleware('auth')->name('sounds.create');