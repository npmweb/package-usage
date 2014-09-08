<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

global $namespace;

if( preg_match( '/^frontend/', App::environment() ) ) {
	$namespace = 'NpmWeb\PackageUsage\Controllers\Frontend\\';
	Route::get('/', $namespace.'OrganizationsController@index');
	Route::get('monitor', $namespace.'MonitorController@index');
}

if( preg_match( '/^backend/', App::environment() ) ) {
	$namespace = 'NpmWeb\PackageUsage\Controllers\Backend\\';

	Route::get('monitor', $namespace.'MonitorController@index');

	Route::get('login', $namespace.'LoginsController@create');
	Route::resource('logins', $namespace.'LoginsController', ['only'=>['create','store','destroy']]);

	Route::group(['before'=>['auth','csrf_resource']], function() {
		global $namespace;

		Route::get('/', $namespace.'OrganizationsController@index');
		Route::resource('organizations', $namespace.'OrganizationsController');

	});
}
