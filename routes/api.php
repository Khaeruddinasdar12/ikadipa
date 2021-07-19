<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// SETTING
Route::get('/jurusan', 'Api\SettingController@jurusan'); //jurusan
Route::get('/provinsi', 'Api\SettingController@provinsi'); //provinsi
Route::get('/kota', 'Api\SettingController@kota'); //kota

// login user
Route::post('/register', 'Api\UserController@register'); //register user

Route::post('/login', 'Api\Admin\UserController@login'); //login user

