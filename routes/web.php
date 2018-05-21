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

Route::view('/ads-file/create', 'ads-file.create')->name('ads-file.create');

Route::post('/ads-file', 'AdsTxtController@store')->name('ads-file.post');
