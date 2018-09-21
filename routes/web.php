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
Route::post('/candidate/add', [
	'uses' => 'HomeController@register',
	'as' => 'candidate.register',
]);

Route::group(['prefix' => 'hq', 'middleware' => 'admin'], function() {
	Route::get('/dashboard', [
		'uses' => 'dashboardPageController@hq_dashboard',
		'as' => 'hqPanel',
	]);
	Route::post('/sidebar', 'dashboardPageController@screening');
	Route::get('/screening', 'ScreeningController@screening');
	Route::post('/screening/profile', 'profileController@profile');
	Route::get('/screening/HUC/{code}', 'ScreeningController@huc');
	Route::get('/screening/PROVINCE/{code}', 'ScreeningController@municipality');
	Route::get('/screening/CITY/{code}', 'ScreeningController@city');
	Route::get('/screening/MUNICIPALITY/{code}', 'ScreeningController@municipality');
});

Route::group(['prefix' => 'lec', 'middleware' => 'auth'], function() {
	Route::get('/','LECController@lec_dashboard');
	Route::get('/candidates','LECController@lec_candidates');
});

