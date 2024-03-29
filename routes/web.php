<?php

use Illuminate\Support\Facades\Route;

Auth::routes([
	'login' => false,
	'register' => false,
]);

Route::get('test', 'Admin\ManageAlumniController@test');

Route::get('test-email', function(){
	return view('email', [
		'name' => 'Khaeruddin Asdar, S.Kom',
		'status' => 'DISETUJUI',
		'pesan' => 'Silakan Login Pada Aplikasi',
		'keterangan' => 'Tidak ada',
		'class' => 'success',

	]);
});

Route::prefix('admin')->group(function() {
	// AUTH
	Route::get('/login', 'Auth\AdminAuthController@getLogin')->name('admin.login');
	Route::post('/login', 'Auth\AdminAuthController@postLogin')->name('admin.submit.login');
	Route::post('/logout', 'Auth\AdminAuthController@postLogout')->name('admin.logout');
	// END AUTH

	// DASHBOARD
	Route::get('/', 'Admin\DashboardController@index');
	Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
	// END DASHBOARD
	

	// DATA ALUMNI
	Route::get('data-alumni', 'Admin\DataAlumniController@index')->name('data.alumni');
	Route::post('import-alumni', 'Admin\DataAlumniController@import')->name('import.alumni');
	Route::post('data-alumni', 'Admin\DataAlumniController@store')->name('data.alumni');
	Route::get('data-alumni/{id}', 'Admin\DataAlumniController@edit')->name('edit.alumni');
	Route::put('data-alumni/{id}', 'Admin\DataAlumniController@update')->name('update.alumni');
	Route::delete('data-alumni/{id}', 'Admin\DataAlumniController@destroy')->name('delete.alumni');
	Route::put('check-valid/{id}', 'Admin\DataAlumniController@cek')->name('cek.alumni');
	Route::get('check-valid/{id}', 'Admin\DataAlumniController@cek'); //cek only

	// MANAGE ALUMNI
	Route::prefix('manage-alumni')->group(function() {
		Route::get('alumni', 'Admin\ManageAlumniController@alumni')->name('alumni.alumni');
		Route::get('mendaftar', 'Admin\ManageAlumniController@mendaftar')->name('alumni.mendaftar');
		Route::get('ditolak', 'Admin\ManageAlumniController@ditolak')->name('alumni.ditolak');

		Route::get('show/{id}', 'Admin\ManageAlumniController@show')->name('alumni.show');

		Route::put('konfirmasi/{id}', 'Admin\ManageAlumniController@konfirmasi')->name('alumni.konfirmasi');
		Route::put('tolak/{id}', 'Admin\ManageAlumniController@tolak')->name('alumni.tolak');
		
		Route::post('edit-password', 'Admin\ManageAlumniController@editPassword')->name('alumni.edit.password');
		//edit password alumni
		Route::get('/table-alumni', 'Admin\ManageAlumniController@tableAlumni')->name('table.alumni');
		Route::get('/table-alumni-mendaftar', 'Admin\ManageAlumniController@tableMendaftar')->name('table.alumni.mendaftar');
		Route::get('/table-alumni-ditolak', 'Admin\ManageAlumniController@tableDitolak')->name('table.alumni.ditolak');
	});
	// END MANAGE ALUMNI

	// ADMIN
	Route::get('/manage-admin', 'Admin\ManageAdminController@index')->name('manageadmin.index');
	Route::post('/manage-admin', 'Admin\ManageAdminController@store')->name('manageadmin.store');
	Route::delete('/delete-admin/{id}', 'Admin\ManageAdminController@delete')->name('manageadmin.delete');
	Route::get('/table-admin', 'Admin\ManageAdminController@tableAdmin')->name('table.manageadmin');
	// END ADMIN

	// WIRAUSAHA
	Route::prefix('wirausaha')->group(function() {
		Route::get('/', 'Admin\WirausahaController@index')->name('wirausaha.index');
		
		Route::get('/table-wirausaha', 'Admin\WirausahaController@tableWirausaha')->name('table.wirausaha');
	});
	// END WIRAUSAHA

	// DONASI
	Route::prefix('donasi')->group(function() {
		Route::get('/', 'Admin\DonasiController@index')->name('donasi.index');
		Route::get('/create', 'Admin\DonasiController@create')->name('donasi.create');
		Route::post('/', 'Admin\DonasiController@store')->name('donasi.store');
		Route::get('/show/{id}', 'Admin\DonasiController@show')->name('donasi.show');
		Route::get('edit/{id}', 'Admin\DonasiController@edit')->name('donasi.edit');
		Route::put('edit/{id}', 'Admin\DonasiController@update')->name('donasi.update');
		Route::delete('delete-donasi/{id}', 'Admin\DonasiController@delete')->name('donasi.delete');
		
		Route::get('/table-donasi', 'Admin\DonasiController@tableDonasi')->name('table.donasi');
	});
	// END DONASI

	// EVENT
	Route::prefix('event')->group(function() {
		Route::get('/', 'Admin\EventController@index')->name('event.index');
		Route::get('/riwayat', 'Admin\EventController@riwayat')->name('event.riwayat');
		Route::get('/create', 'Admin\EventController@create')->name('event.create');
		Route::post('/', 'Admin\EventController@store')->name('event.post');
		Route::get('edit/{id}', 'Admin\EventController@edit')->name('event.edit');
		Route::put('edit/{id}', 'Admin\EventController@update')->name('event.update');
		Route::put('status-event/{id}', 'Admin\EventController@ubahStatus');
		Route::delete('delete-event/{id}', 'Admin\EventController@delete')->name('event.delete');
		
		Route::get('/table-event', 'Admin\EventController@tableEvent')->name('table.event');
		Route::get('/table-riwayat-event', 'Admin\EventController@tableRiwayatEvent')->name('table.riwayat.event');
	});
	// END EVENT

	// BERITA
	Route::prefix('berita')->group(function() {

		Route::get('/manage-kategori', 'Admin\BeritaController@kategori')->name('berita.kategori');
		Route::post('/manage-kategori', 'Admin\BeritaController@postKategori')->name('post.kategori.berita');
		Route::post('/edit-kategori', 'Admin\BeritaController@editKategori')->name('edit.kategori.berita');
		Route::delete('/delete-kategori/{id}', 'Admin\BeritaController@deleteKategori')->name('delete.kategori.berita');

		Route::get('/test', 'Admin\BeritaController@test');
		Route::get('/', 'Admin\BeritaController@index')->name('berita.index');
		Route::get('/create', 'Admin\BeritaController@create')->name('berita.create');
		Route::post('/create', 'Admin\BeritaController@store')->name('berita.store');
		Route::get('/edit/{id}', 'Admin\BeritaController@edit')->name('berita.edit');
		Route::put('/edit/{id}', 'Admin\BeritaController@update')->name('berita.update');
		Route::get('/show/{id}', 'Admin\BeritaController@show')->name('berita.show');
		Route::delete('/delete-berita/{id}', 'Admin\BeritaController@delete')->name('delete.berita');

		Route::get('/table-berita', 'Admin\BeritaController@tableBerita')->name('table.berita');
		Route::get('/table-kategori-berita', 'Admin\BeritaController@tableKategori')->name('table.kategori.berita');
	});
	// END BERITA

	// PROMO
	Route::get('/manage-promo', 'Admin\PromoController@index')->name('admin.promo');
	Route::post('/manage-promo', 'Admin\PromoController@store')->name('admin.promo');
	Route::delete('/delete-promo/{id}', 'Admin\PromoController@delete')->name('delete.promo');
	Route::get('/table-promo', 'Admin\PromoController@tablePromo')->name('table.promo');
	// END PROMO

	// NOTIFICATION
	Route::get('/test-notif', 'Admin\NotificationController@sendNotification');
	Route::get('/notification', 'Admin\NotificationController@index')->name('notification.index');
	Route::post('/notification', 'Admin\NotificationController@store')->name('notification.store');

	Route::get('/table-notification', 'Admin\NotificationController@tableNotification')->name('table.notification');
	// END NOTIFICATION

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


