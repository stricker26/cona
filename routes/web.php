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
	Route::get('/screening/profile', 'profileController@redirect');
	Route::get('/screening/profile/sent', 'profileController@redirect');
	Route::get('/screening/profile/approve', 'profileController@redirect');
	Route::get('/screening/profile/reject', 'profileController@redirect');
	Route::post('/screening/profile', 'profileController@profile');
	Route::post('/screening/profile/sent', 'profileController@sent');
	Route::post('/screening/profile/approve', 'profileController@approve');
	Route::post('/screening/profile/reject', 'profileController@reject');
	Route::get('/screening/HUC/{code}', 'ScreeningController@huc');
	Route::get('/screening/PROVINCE/{code}', 'ScreeningController@district');
	Route::get('/screening/CITY/{code}', 'ScreeningController@city');
	Route::get('/screening/ICC/{code}', 'ScreeningController@cc');
	Route::get('/screening/MUNICIPAL/{code}', 'ScreeningController@cc');
	Route::get('/screening/MUNICIPALITY/{code}', 'ScreeningController@municipality');
	Route::get('/screening/REGION/{code}', 'ScreeningController@region');
	Route::get('/screening/candidate/city', 'ScreeningController@candidate');
	Route::get('/screening/candidate/district', 'ScreeningController@districtCandidate');
	Route::get('/screening/candidate/governor', 'ScreeningController@governor');
	Route::post('/status', 'statCandidatesController@status');
	Route::get('/status', 'profileController@redirect');
});

Route::group(['prefix' => 'lec', 'middleware' => 'auth'], function() {
	Route::get('/','LECController@lec_dashboard');
	Route::get('/candidates','LECController@lec_candidate');
	Route::post('/status', 'LECController@status');
	Route::get('/screening', 'LECController@screening');
	Route::get('/screening/HUC/{code}', 'LECController@huc');
	Route::get('/screening/PROVINCE/{code}', 'LECController@municipality');
	Route::get('/screening/CITY/{code}', 'LECController@city');
	Route::get('/screening/CC/{code}', 'LECController@cc');
	Route::get('/screening/MUNICIPAL/{code}', 'LECController@cc');
	Route::get('/screening/MUNICIPALITY/{code}', 'LECController@municipality');
	Route::get('/screening/REGION/{code}', 'LECController@region');
	Route::get('/screening/count/{province}/{district}', 'LECController@count');
	Route::post('/screening/profile', 'profileController@profile_lec');
	Route::post('/screening/profile/approve', 'profileController@approve_lec');
});