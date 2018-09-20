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

Route::get('hq/dashboard', 'HomeController@admin')->middleware('admin');

Route::post('/candidate/add', [
	'uses' => 'HomeController@register',
	'as' => 'candidate.register',
]);

Route::post('/sidebar', 'dashboardPageController@screening');
Route::get('/dashboard', 'dashboardPageController@hq_dashboard');
Route::get('/lec','dashboardPageController@lec_dashboard');
Route::get('/lec/candidates','dashboardPageController@lec_candidates');

Route::get('/screening', 'ScreeningController@screening');
Route::get('/screening/{code}', 'ScreeningController@table');

Route::post('/dashboard/profile', 'profileController@profile');
Route::get('/dashboard/profile', 'profileController@profile');
Route::post('/dashboard/profile/sent', 'profileController@sent');

Route::get('/screening/HUC/{code}', 'ScreeningController@huc');
Route::get('/screening/PROVINCE/{code}', 'ScreeningController@municipality');
Route::get('/screening/CITY/{code}', 'ScreeningController@city');
Route::get('/screening/MUNICIPALITY/{code}', 'ScreeningController@municipality');
