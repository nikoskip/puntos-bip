<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'PuntosBipController@home');


Route::get('/api', function () {
    abort(404);
});

Route::group(['namespace' => 'Api'], function() {
    Route::get('/api/getByAddress', 'PuntosBipApiController@getByAddress');
    Route::get('/api/getByLocation', 'PuntosBipApiController@getByLocation');
});