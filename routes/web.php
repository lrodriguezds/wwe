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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    
    Route::get('/videos', 'VideoController@index');
    Route::get('/videos/create', 'VideoController@create');
    Route::post('/videos', 'VideoController@store');
    Route::get('/videos/{id}', ['middleware' => 'check-video', 'uses' => 'VideoController@show']);

    Route::get('/video/{filename}', 'VideoController@stream');

    Route::post('/videos/metadata', 'VideoController@storeMetadata');

    Route::get('/liked-videos', 'VideoController@likedList');
    Route::get('/videos/{id}/like', 'VideoController@like');
    Route::get('/videos/{id}/unlike', 'VideoController@unlike');
});

