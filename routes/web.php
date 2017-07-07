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

Route::resource('videos', 'VideoController');

Route::get('/video/{filename}', function ($filename) {

    $videosDir = base_path('public/uploads');
    if (file_exists($filePath = $videosDir."/".$filename)) {
        $stream = new \App\Http\VideoStream($filePath);
        return response()->stream(function() use ($stream) {
            $stream->start();
        });
    }
    return response("File doesn't exists", 404);
});