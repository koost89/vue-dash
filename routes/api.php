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

Route::group(['middleware' => ['auth:api']], function() {

    Route::get('customers', 'CustomerController@index');
    Route::post('customers/create', 'CustomerController@create');
    Route::post('customers/delete', 'CustomerController@destroy');
    Route::patch('customers/{customer}', 'CustomerController@update');
    Route::get('customers/{customer}', 'CustomerController@show');
    Route::post('customers/search', 'CustomerController@search');

    Route::get('projects', 'ProjectController@index');
    Route::post('projects/create', 'ProjectController@create');
    Route::post('projects/delete', 'ProjectController@destroy');
    Route::patch('projects/{project}', 'ProjectController@update');
    Route::get('projects/{project}', 'ProjectController@show');
    Route::post('projects/search', 'ProjectController@search');

    Route::get('billings', 'BillingController@index');
    Route::post('billings/create', 'BillingController@create');
    Route::post('billings/delete', 'BillingController@destroy');
    Route::patch('billings/{billing}', 'BillingController@update');
    Route::get('billings/{billing}', 'BillingController@show');

    Route::get('user', function (Request $request) {
        return $request->user();
    });

});
