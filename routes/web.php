<?php

use Illuminate\Support\Facades\Route;

Auth::routes([
	'login' => false,
	'register' => false,
]);

Route::prefix('admin')->group(function() {
	// AUTH
	Route::get('/login', 'Auth\AdminAuthController@getLogin')->name('admin.login');
	Route::post('/login', 'Auth\AdminAuthController@postLogin')->name('admin.submit.login');
	Route::post('/logout', 'Auth\AdminAuthController@postLogout')->name('admin.logout');
	// END AUTH

	// DASHBOARD
	Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
	// END DASHBOARD
	
	// BERITA
	Route::prefix('berita')->group(function() {

		Route::get('/tambah-kategori', 'Admin\BeritaController@kategori')->name('berita.kategori');
		Route::post('/tambah-kategori', 'Admin\BeritaController@postKategori')->name('post.kategori.berita');
		Route::post('/edit-kategori', 'Admin\BeritaController@editKategori')->name('edit.kategori.berita');
		Route::delete('/delete-kategori/{id}', 'Admin\BeritaController@deleteKategori')->name('delete.kategori.berita');

		Route::get('/table-kategori-berita', 'Admin\BeritaController@tableKategori')->name('table.kategori.berita');
	});
	// END BERITA

	// SETTING
	Route::get('/setting', 'Admin\SettingController@index')->name('admin.setting');

	Route::post('/post-jurusan', 'Admin\SettingController@postJurusan')->name('admin.post.jurusan');
	Route::post('/post-kategori', 'Admin\SettingController@postKategori')->name('admin.post.kategori');

	Route::post('/edit-jurusan', 'Admin\SettingController@editJurusan')->name('edit.jurusan');
	Route::post('/edit-kategori', 'Admin\SettingController@editKategori')->name('edit.kategori');

	Route::delete('/delete-jurusan/{id}', 'Admin\SettingController@deleteJurusan')->name('delete.jurusan');
	Route::delete('/delete-kategori/{id}', 'Admin\SettingController@deleteKategori')->name('delete.kategori');

	Route::get('/table-kategori-perusahaan', 'Admin\SettingController@tableKategori')->name('table.kategori');
	Route::get('/table-jurusan', 'Admin\SettingController@tableJurusan')->name('table.jurusan');
	// SETTING
	

	

	
});


