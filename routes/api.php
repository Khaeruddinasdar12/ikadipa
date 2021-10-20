<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// SETTING
Route::get('/jurusan', 'Api\SettingController@jurusan'); //jurusan
Route::get('/provinsi', 'Api\SettingController@provinsi'); //provinsi
Route::get('/promo', 'Api\PromoController@index'); // data promo

Route::post('/kota', 'Api\SettingController@kota'); //kota
Route::get('/kategori-perusahaan', 'Api\SettingController@kategoriPerusahaan'); //kategori perusahaan 

// login user
Route::post('/register', 'Api\UserController@register'); //register user
Route::post('/login', 'Api\UserController@login'); //login user
Route::post('/myprofile', 'Api\UserController@myprofile'); //profile yang login
Route::post('/edit-profile', 'Api\UserController@update'); //edit profile


// API ALUMNI
Route::post('/data-alumni', 'Api\AlumniController@index');

// API BERITA
Route::get('/berita', 'Api\BeritaController@berita'); //list berita
Route::post('/berita', 'Api\BeritaController@show'); //detail berita
Route::get('/kategori-berita', 'Api\BeritaController@kategori'); //list kategori berita
Route::post('/kategori-berita', 'Api\BeritaController@kategoriBerita'); //list berita per kategori

// API EVENT
Route::get('/event', 'Api\EventController@event'); //list event
Route::post('/event', 'Api\EventController@show'); //detail event

// API DONASI
Route::get('/donasi', 'Api\DonasiController@donasi'); //list donasi
Route::post('/donasi', 'Api\DonasiController@show'); //detail donasi

// API FEED
Route::post('/myfeed', 'Api\FeedController@myfeed'); // melihat feed berdasarkan login
Route::get('/feed', 'Api\FeedController@index'); // index
Route::post('/post-feed', 'Api\FeedController@store'); // post feed
Route::post('/delete-feed', 'Api\FeedController@delete'); //delete feed
Route::post('/detail-feed', 'Api\FeedController@detail'); //deta feed

// API WIRAUSAHA
Route::post('/post-wirausaha', 'Api\WirausahaController@store'); // post wirausaha
Route::post('/data-wirausaha', 'Api\WirausahaController@index'); // data wirausaha
Route::post('/wirausaha-profile', 'Api\WirausahaController@wirausaha'); // per login/profile
Route::post('/edit-wirausaha', 'Api\WirausahaController@update'); // edit wirausaha
Route::post('/delete-wirausaha', 'Api\WirausahaController@delete'); // delete wirausaha


