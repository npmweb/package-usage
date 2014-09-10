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

$namespace = 'NpmWeb\PackageUsage\Controllers\\';
Route::get('/', $namespace.'PackagesController@index');
Route::get('/test', $namespace.'PackagesController@test');
Route::get('monitor', $namespace.'MonitorController@index');
