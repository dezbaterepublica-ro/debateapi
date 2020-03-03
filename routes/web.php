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

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);
Route::resource('debate', 'Unauthenticated\DebateController', ['only' => ['index', 'show']]);
Route::resource('authority', 'Unauthenticated\AuthorityController', ['only' => ['index', 'show']]);
Route::resource('city', 'Unauthenticated\CityController', ['only' => ['index', 'show']]);
Route::resource('county', 'Unauthenticated\CountyController', ['only' => ['index', 'show']]);
