<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!

Attention!!!!!!! Что бы после регистрации нового усера не логинилось, закомментировано vendor/laravel/framework/src/Illuminate/Foundation/Auth/RegistersUsers.php:35
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/upload', 'UploadController@index')->name('upload');
//Route::post('/upload', 'UploadController@upload');

Route::get('/users', 'UsersController@show')->name('users_show');
Route::get('/users/delete/{id}', 'UsersController@delete')->name('user_delete');
/*    [
        'before' => 'csrf',
        function()
        {
            return ;
        }
    ]
);*/
Route::get('/import', 'ImportController@import')->name('import');

Route::get('/catalog', 'CatalogController@show')->name('catalog_show');

Route::get('/clients', function (){
    return view('clients.clients');
})->name('clients_show');
/*Route::get('/clients/new', function (){
    return view('clients.clients_form');
})->name('clients_new');
Route::post('clients/new', 'ClientsController@create');*/
