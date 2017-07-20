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

Route::get('/home', 'HomeController@index');
Route::get('/home/favorited', 'HomeController@favorited');
Route::get('/servers/xbox', 'ServerController@xboxindex');
Route::get('/servers/playstation', 'ServerController@playstationindex');
Route::get('/servers/search', 'ServerController@search')->name('servers.search');
Route::get('/servers/{id}/like', 'ServerController@likeserver');
Route::get('/servers/{id}/unlike', 'ServerController@unlikeserver');
Route::resource('servers','ServerController');
