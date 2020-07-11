<?php

use Illuminate\Support\Facades\Route;

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
    return view('index');
});
Route::resource('deals', 'DealController');
Route::get('deals', [
    'as' =>     'deals.index',
    'uses' =>'DealController@index'
]);
Route::post('deals/create', [
    'as' =>     'deals.store',
    'uses' =>'DealController@store'
]);
Route::get('deals/edit/{id}', [
    'as' =>     'deals.edit',
    'uses' =>'DealController@edit'
]);
Route::patch('deals/{id}', [
    'as' =>     'deals.update',
    'uses' =>'DealController@update'
]);
Route::delete('deals/{id}', [
    'as' =>     'deals.destroy',
    'uses' =>'DealController@destroy'
]);
Route::get('deals/{id}', [
    'as' =>     'deals.show',
    'uses' =>'DealController@show'
]);

// Activity
Route::resource('activities', 'ActivityController');
Route::get('activities', [
    'as' =>     'activities.index',
    'uses' =>'ActivityController@index'
]);
Route::post('activities/create', [
    'as' =>     'activities.store',
    'uses' =>'ActivityController@store'
]);
Route::get('activities/edit/{id}', [
    'as' =>     'activities.edit',
    'uses' =>'ActivityController@edit'
]);
Route::patch('activities/{id}', [
    'as' =>     'activities.update',
    'uses' =>'ActivityController@update'
]);
Route::delete('activities/{id}', [
    'as' =>     'activities.destroy',
    'uses' =>'ActivityController@destroy'
]);
Route::get('activities/{id}', [
    'as' =>     'activities.show',
    'uses' =>'ActivityController@show'
]);

// connect
Route::get('connect/create', [
    'as' => 'connect.createAction',
    'uses' => 'ConnectController@createAction'
]);
Route::get('/', [
    'as' => 'connect.index',
    'uses' => 'ConnectController@index'
]);
Route::get('connect/update', [
    'as' => 'connect.updateAction',
    'uses' => 'ConnectController@updateAction'
]);
// parser
Route::get('parser', [
    'as' => 'parse.index',
    'uses' => 'ParseController@index'
]);
Route::get('lookup', [
    'as' => 'parse.allLookup',
    'uses' => 'ParseController@allLookup'
]);
Route::get('record', [
    'as' => 'parse.allRecords',
    'uses' => 'ParseController@allRecords'
]);
Route::get('fields', [
    'as' => 'parse.fields',
    'uses' => 'ParseController@fields'
]);

