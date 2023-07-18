<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/mba-player/create-many' ,                    [  'uses'        => 'App\Http\Controllers\MBAPLayerController@create_many']);
Route::get('/mba-player/mapping' ,                    [  'uses'        => 'App\Http\Controllers\MBAPLayerController@create_mapping']);
Route::get('/mba-player/show-mapping' ,                    [  'uses'        => 'App\Http\Controllers\MBAPLayerController@show_mapping']);
Route::get('/mba-player/show/{id}' ,         [  'uses'        => 'App\Http\Controllers\MBAPLayerController@show']);
Route::get('/mba-player/update/{id}' ,         [  'uses'        => 'App\Http\Controllers\MBAPLayerController@update']);
Route::get('/mba-player/fuzzy-search-first-name/{first_name}' ,         [  'uses'        => 'App\Http\Controllers\MBAPLayerController@fuzzy_search_first_name']);
Route::get('/mba-player/search-first-name/{first_name}' ,         [  'uses'        => 'App\Http\Controllers\MBAPLayerController@search_first_name']);
Route::get('/mba-player/search-aggregate' ,         [  'uses'        => 'App\Http\Controllers\MBAPLayerController@search_aggregate']);
Route::get('/mba-player/search-paginate' ,         [  'uses'        => 'App\Http\Controllers\MBAPLayerController@search_paginate']);
Route::get('/mba-player/delete/{id}' ,         [  'uses'        => 'App\Http\Controllers\MBAPLayerController@delete']);
Route::get('/mba-player/delete-index' ,         [  'uses'        => 'App\Http\Controllers\MBAPLayerController@delete_index']);



Route::get('/kibana-course/bulk-logs' ,         [  'uses'        => 'App\Http\Controllers\KibanaCourseController@bulkLogs']);
