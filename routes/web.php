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

Route::get('/', 'PagesController@index');
Route::get('/info', 'PagesController@info');
Route::get('/table', 'PagesController@table');
Route::get('/predictions', 'PagesController@predictions');
Route::get('/results', 'PagesController@results');
Route::get('/cl_draw', 'PagesController@clDraw');
Route::get('/cl_results', 'PagesController@clResults');
Route::get('/cl_statistics', 'PagesController@clStatistics');







