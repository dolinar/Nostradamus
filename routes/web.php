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
Route::get('/instructions', 'PagesController@instructions');
Route::get('/table', 'PagesController@table');
Route::get('/cl_draw', 'PagesController@clDraw');
Route::get('/cl_statistics', 'PagesController@clStatistics');

Route::resource('predictions', 'PredictionsController', [
    'only' => ['index', 'show', 'edit', 'update']
]);

Route::resource('teams', 'TeamsController');

Route::resource('matchdays', 'MatchdaysController', [
    'only' => ['index', 'show']
]);

Route::resource('overall_prediction', 'OverallPredictionsController', [
    'only' => ['index', 'update', 'store']
]);

Route::resource('cl_results', 'FixturesController');

//Auth::routes(['verify' => true]);
//Route::get('/dashboard', 'DashboardController@index')->middleware('verified');
Auth::routes();
Route::get('/dashboard', 'DashboardController@index');

//languages
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);