<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_catalog', 'API\CatalogController@get_list');

Route::post('/get_catalog', 'API\CatalogController@get_articles');//middleware('auth:api')->

Route::get('/import', 'API\ImportController@import');

Route::post('/upload', 'API\UploadController@upload');

//Route::middleware('auth:api')->post('/upload', 'API\UploadController@upload');

Route::get('/upload', function (){
    return abort(404);
});

Route::get('/showClients', 'API\ClientsController@show');
Route::post('/addClient', 'API\ClientsController@create');

Route::post('/deleteClient', 'API\ClientsController@delete');
Route::post('/getClient', 'API\ClientsController@getClient');