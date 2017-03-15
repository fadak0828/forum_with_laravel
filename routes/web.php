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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [
  'as'=>'home',
  'uses'=>'HomeController@index']);

Route::group(['prefix' => 'auth', 'as' => 'session.'], function () {
    // Other route definitions...

    /* Social Login */
    Route::get('github', [
        'as'   => 'github.login',
        'uses' => 'Auth\LoginController@redirectToProvider'
    ]);
    Route::get('github/callback', [
        'as'   => 'github.callback',
        'uses' => 'Auth\LoginController@handleProviderCallback'
    ]);
});

Route::get('locale',[
  'as'=>'locale',
  'uses'=>'HomeController@locale'
]);
Route::resource('articles','ArticlesController');

Route::resource('files','AttachmentsController',['only'=>['store','destroy']]);
