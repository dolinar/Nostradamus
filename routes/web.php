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
Route::get('/cl_statistics', 'PagesController@clStatistics');

Route::get('/table', 'ParticipantsController@index');

Route::resource('predictions', 'PredictionsController', [
    'only' => ['index', 'edit', 'store', 'update']
]);

Route::resource('teams', 'TeamsController');

Route::resource('matchdays', 'MatchdaysController', [
    'only' => ['index', 'show']
]);

Route::resource('overall_prediction', 'OverallPredictionsController', [
    'only' => ['index', 'update', 'store']
]);

Route::get('cl_results', 'FixturesController@indexResults');
Route::get('cl_draw', 'FixturesController@indexDraw');

//Auth::routes(['verify' => true]);
//Route::get('/dashboard', 'DashboardController@index')->middleware('verified');
Auth::routes();
//Route::get('/dashboard', 'DashboardController@index');

//groups
Route::resource('groups', 'GroupsController');
Route::post('store_user', 'GroupsController@sendInvitation');

//languages
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);

// admin page
Route::get('/admin', 'AdminController@index');   

// live search
//Route::get('/search', 'ParticipantsControler@search');
Route::get('/table/search', 'ParticipantsController@search');

