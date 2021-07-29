<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// SETTING
Route::get('/jurusan', 'Api\SettingController@jurusan'); //jurusan
Route::get('/provinsi', 'Api\SettingController@provinsi'); //provinsi
Route::get('/kota', 'Api\SettingController@kota'); //kota
Route::get('/kategori-perusahaan', 'Api\SettingController@kategoriPerusahaan'); //kategori perusahaan 

// login user
Route::post('/register', 'Api\UserController@register'); //register user

Route::post('/login', 'Api\Admin\UserController@login'); //login user

// API BERITA
Route::get('/berita', 'Api\BeritaController@berita'); //list berita

// API EVENT
Route::get('/event', 'Api\EventController@event'); //list event

// API DONASI
Route::get('/donasi', 'Api\DonasiController@donasi'); //list donasi

// API FEED
Route::get('/feed', 'Api\FeedController@index'); // index


