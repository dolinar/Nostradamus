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

Route::resource('dashboard', 'DashboardController', [
    'only' => ['index', 'edit', 'update']
]);

Route::get('/', 'PagesController@index');
Route::get('/info', 'PagesController@info')->name('info');
Route::get('/instructions', 'PagesController@instructions')->name('instructions');
Route::get('/cl_statistics', 'PagesController@clStatistics');

Route::get('/table', 'ParticipantsController@index');

Route::resource('predictions', 'PredictionsController', [
    'only' => ['index', 'edit', 'store', 'update']
]);

Route::resource('teams', 'TeamsController');

Route::resource('overall_prediction', 'OverallPredictionsController', [
    'only' => ['index', 'update', 'store']
]);

Route::resource('user_profile', 'ProfilesController', [
    'only' => ['update', 'show']
]);

Route::get('cl_results', 'FixturesController@indexResults');
Route::get('cl_draw', 'FixturesController@indexDraw');

//Auth::routes(['verify' => true]);
//Route::get('/dashboard', 'DashboardController@index')->middleware('verified');
Auth::routes(['verify' => true]);
//Route::get('/dashboard', 'DashboardController@index');

//groups
Route::resource('groups', 'GroupsController');

Route::post('send_invitation', 'GroupsController@sendInvitation');
Route::post('store_user_to_group', 'GroupsController@storeUser');
Route::post('remove_user', 'GroupsController@removeUser');
Route::post('leave_group', 'GroupsController@leaveGroup');

//languages
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);

// admin page
Route::get('admin', 'AdminController@index')->name('admin');   
Route::post('create_matchday', 'AdminController@createMatchday'); 
Route::post('create_fixture', 'AdminController@createFixture');   
Route::post('finish_fixture', 'AdminController@finishFixture');   



// live search
Route::get('/table/search', 'ParticipantsController@search');
//Route::get('/group/search', 'GroupController@search');

// private messages
Route::resource('private_message', 'PrivateMessagesController')->except([
    'create', 'edit', 'update'
]);
Route::get('private_message/create/{id}', 'PrivateMessagesController@create')->name('send_private');

// chatroom
Route::post('send_chatroom_message', [
    'as' => 'send_chatroom_message',
    'uses' => 'ChatroomMessagesController@fireEvent'
]);

Route::post('live_match/send_fixture_chatroom_message', [
    'as' => 'send_fixture_chatroom_message',
    'uses' => 'FixtureChatroomMessagesController@fireEvent'
]);

Route::get('get_chatroom_messages/{count}', 'ChatroomMessagesController@getChatroomMessages')->name('get_chatroom_messages');

Route::resource('news', 'NewsController');

// Live fixture
Route::get('live_match/{id}', 'FixturesController@showLiveMatch')->name('live_match');

// SOCIALITE
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');