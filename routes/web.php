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
<<<<<<< HEAD

Route::get('/geo', 'GeoLocationController@location');

Route::post('/register', [
	'uses' => 'HomeController@register',
	'as' => 'register',
]);

Route::get('hq/dashboard', 'HomeController@admin')->middleware('admin');
=======
Route::post('/register', [
	'uses' => 'HomeController@register',
	'as' => 'register',
])->middleware('admin');

Route::get('hq/dashboard', 'HomeController@admin')->middleware('admin');

Route::get('/dashboard', 'dashboardPageController@dashboard');
Route::get('/nomination/pending', 'dashboardPageController@pending');
Route::get('/nomination/approve', 'dashboardPageController@approve');
Route::get('/nomination/reject', 'dashboardPageController@reject');
>>>>>>> origin/dashboard-page
