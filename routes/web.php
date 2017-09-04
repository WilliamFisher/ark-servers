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

Route::get('/feedback', function () {
  return view('typeform');
});

Route::get('/servers/{server}/rating', 'ServerController@getRating');

Auth::routes();

Route::get('/login/redirect/{provider}', 'SocialAuthController@redirect');
Route::get('/login/callback/{provider}', 'SocialAuthController@callback');

Route::get('/dashboard', 'HomeController@index');

Route::get('/servers/search', 'ServerController@search')->name('servers.search');
Route::get('/servers/{server}/like', 'ServerController@likeserver');
Route::get('/servers/{server}/unlike', 'ServerController@unlikeserver');
Route::get('/servers/{server}/claim', 'ServerController@claim');
Route::get('/servers/xbox', 'ServerController@xbox');
Route::get('/servers/playstation', 'ServerController@playstation');
Route::get('/servers/{server}/rate', 'ServerController@rateserver');

Route::resource('servers','ServerController');
