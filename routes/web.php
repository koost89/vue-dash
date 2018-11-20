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
Route::post('login', '\App\Api\Auth\LoginController@login');
Route::post('login/refresh', '\App\Api\Auth\LoginController@refresh');

Route::group(['middleware' => ['auth:api']], function() {
    Route::post('logout', '\App\Api\Auth\LoginController@logout');
});

Route::get('/{any}', '\App\Http\Controllers\SpaController@index')->where('any', '.*');
