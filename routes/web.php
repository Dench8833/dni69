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

Route::get('/home', 'HomeController@index')->name('home');


/*==============Admin block======================================================*/
Auth::routes();

Route::get('/admin', 'AdminController@index')->name('admin');

Route::get('/admin/songs', 'SongsController@index')->name('songs');
Route::get('/admin/song/create', 'SongsController@create')->name('song.create');
Route::get('/admin/song/edit/{id}', 'SongsController@edit')->name('song.edit');
Route::post('/admin/song/update', 'SongsController@update')->name('song.update');
Route::get('/admin/song/show/{id}', 'SongsController@show')->name('song.show');
Route::get('/admin/song/delete/{id}', 'SongsController@delete')->name('song.delete');
Route::post('/admin/song/store', 'SongsController@store')->name('song.store');

Route::get('/admin/albums', 'AlbumController@index')->name('albums');
Route::post('/admin/albums_crud', 'AlbumController@ajaxAlbum')->name('albums_crud');

Route::get('/admin/verses', 'VersesController@index')->name('verses');
Route::get('/admin/verse/create', 'VersesController@create')->name('verse.create');
Route::get('/admin/verse/edit/{id}', 'VersesController@edit')->name('verse.edit');
Route::get('/admin/verse/show/{id}', 'VersesController@show')->name('verse.show');
Route::get('/admin/verse/delete/{id}', 'VersesController@delete')->name('verse.delete');
