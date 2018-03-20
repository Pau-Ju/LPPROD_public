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



Route::get('/', 'HomeController@index')->name('home');

Auth::routes();


Route::get('/confirm/{id}/{token}', 'Auth\RegisterController@confirm');

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/search', ['as' => 'search', 'uses' => 'SearchController@index']);

Route::get('/favorites', 'FavoritesController@index')->name('favorites')->middleware('auth');

Route::get('/top', ['as' => 'top', 'uses' => 'TopController@index']);

ROute::get('/last' ,['as' => 'last', 'uses' => 'LastController@index']);

Route::get('/serie/{id}/{name}', 'SerieController@get');

Route::get('/advise', ['as' => 'advise' ,'uses' => 'AdviseController@index'])->middleware('auth');




