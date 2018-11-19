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

Route::get('/upload', 'UploadController@index')->name('upload');
Route::post('/upload', 'UploadController@upload');

Route::get('/users', 'UsersController@show')->name('users_show');
/*    [
        'before' => 'csrf',
        function()
        {
            return ;
        }
    ]
);*/
Route::get('/import', 'ImportController@import')->name('import');
