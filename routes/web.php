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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/geo', 'GeoLocationController@location');

Route::post('/register', [
	'uses' => 'HomeController@register',
	'as' => 'register',
]);

Route::get('hq/dashboard', 'HomeController@admin')->middleware('admin');