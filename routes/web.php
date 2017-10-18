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

Auth::routes();

Route::get('/', 'Auth\LoginController@showLoginForm');

// Dashboard
Route::get('home', 'DashboardController@index')->name('dashboard');

// Daftar BMT
Route::get('daftar', 'DaftarBmtController@index')->name('daftar.index')->middleware('can:read-daftar');
Route::get('daftar/tambah', 'DaftarBmtController@tambah')->name('daftar.tambah')->middleware('can:create-daftar');
Route::post('daftar/tambah', 'DaftarBmtController@store')->name('daftar.store')->middleware('can:create-daftar');
Route::get('daftar/ubah/{id}', 'DaftarBmtController@ubah')->name('daftar.ubah')->middleware('can:update-daftar');
Route::post('daftar/ubah', 'DaftarBmtController@edit')->name('daftar.edit')->middleware('can:update-daftar');

// Anggota BMT
Route::get('anggota', 'DaftarAnggotaController@index')->name('anggota.index')->middleware('can:read-anggota');
Route::get('anggota/tambah', 'DaftarAnggotaController@tambah')->name('anggota.tambah')->middleware('can:create-anggota');
Route::post('anggota/tambah', 'DaftarAnggotaController@store')->name('anggota.store')->middleware('can:create-anggota');
Route::get('anggota/ubah/{id}', 'DaftarAnggotaController@ubah')->name('anggota.ubah')->middleware('can:update-anggota');
Route::post('anggota/ubah', 'DaftarAnggotaController@edit')->name('anggota.edit')->middleware('can:update-anggota');

// Bidang
Route::get('bidang', 'BidangController@index')->name('bidang.index')->middleware('can:read-bidang');
Route::get('bidang/tambah', 'BidangController@tambah')->name('bidang.tambah')->middleware('can:create-bidang');
Route::post('bidang/tambah', 'BidangController@store')->name('bidang.store')->middleware('can:create-bidang');
Route::get('bidang/ubah/{id}', 'BidangController@ubah')->name('bidang.ubah')->middleware('can:update-bidang');
Route::post('bidang/ubah', 'BidangController@edit')->name('bidang.edit')->middleware('can:update-bidang');
Route::get('bidang/publish/{id}', 'BidangController@publish')->name('bidang.publish')->middleware('can:publish-bidang');

// Posisi
Route::get('posisi', 'PosisiController@index')->name('posisi.index')->middleware('can:read-posisi');
Route::get('posisi/tambah', 'PosisiController@tambah')->name('posisi.tambah')->middleware('can:create-posisi');
Route::post('posisi/tambah', 'PosisiController@store')->name('posisi.store')->middleware('can:create-posisi');
Route::get('posisi/ubah/{id}', 'PosisiController@ubah')->name('posisi.ubah')->middleware('can:update-posisi');
Route::post('posisi/ubah', 'PosisiController@edit')->name('posisi.edit')->middleware('can:update-posisi');
Route::get('posisi/publish/{id}', 'PosisiController@publish')->name('posisi.publish')->middleware('can:publish-posisi');

// Plafon
Route::get('plafon/jiwa', 'PlafonController@jiwa')->name('plafon.jiwa')->middleware('can:read-plafon');
Route::get('plafon/tambah/jiwa', 'PlafonController@tambahJiwa')->name('plafon.jiwa.tambah')->middleware('can:create-plafon');

Route::get('plafon/kebakaran', 'PlafonController@kebakaran')->name('plafon.kebakaran')->middleware('can:read-plafon');
Route::get('plafon/tambah/kebakaran', 'PlafonController@tambahKebakaran')->name('plafon.kebakaran.tambah')->middleware('can:create-plafon');
Route::post('plafon/tambah', 'PlafonController@store')->name('plafon.store')->middleware('can:create-plafon');

Route::get('plafon/ubah/{jenis_plafon}/{jumlah_pembiayaan}', 'PlafonController@ubah')->name('plafon.ubah')->middleware('can:update-plafon');
Route::post('plafon/ubah/', 'PlafonController@edit')->name('plafon.edit')->middleware('can:update-plafon');

Route::get('plafon/template', 'PlafonController@template')->name('plafon.template')->middleware('can:create-plafon');
Route::get('plafon/template/download', 'PlafonController@download')->name('plafon.download')->middleware('can:create-plafon');
Route::post('plafon/template', 'PlafonController@upload')->name('plafon.upload')->middleware('can:create-plafon');

Route::get('plafon/getPlafonList/{jenis_plafon}', 'PlafonController@plafonList');
Route::get('plafon/getPlafonList/{jenis_plafon}/{jumlah_pembiayaan}', 'PlafonController@plafonListBulan');

// Akad
Route::get('akad', 'AkadController@index')->name('akad.index')->middleware('can:read-akad');
Route::get('akad/tambah', 'AkadController@tambah')->name('akad.tambah')->middleware('can:create-akad');
Route::post('akad/tambah', 'AkadController@store')->name('akad.store')->middleware('can:create-akad');
Route::get('akad/approve/{id}', 'AkadController@approve')->name('akad.approve')->middleware('can:approve-akad');
Route::post('akad/approve', 'AkadController@approveStore')->name('akad.approveStore')->middleware('can:approve-akad');

// Iuran
Route::get('iuran', 'IuranController@index')->name('iuran.index')->middleware('can:read-pembayaran');
Route::get('iuran/tambah', 'IuranController@tambah')->name('iuran.tambah')->middleware('can:create-pembayaran');
Route::post('iuran/tambah', 'IuranController@store')->name('iuran.store')->middleware('can:create-pembayaran');
Route::get('iuran/getAkad/{id}', 'IuranController@getAkad')->name('iuran.getAkad')->middleware('can:create-pembayaran');
Route::get('iuran/{kode_iuran}', 'IuranController@hapus')->name('iuran.hapus')->middleware('can:delete-pembayaran');
Route::post('iuran/hapus', 'IuranController@delete')->name('iuran.delete')->middleware('can:delete-pembayaran');

// Klaim
Route::get('klaim', 'KlaimController@index')->name('klaim.index')->middleware('can:read-klaim');
Route::post('klaim', 'KlaimController@check')->name('klaim.check')->middleware('can:read-klaim');
Route::post('klaim/store', 'KlaimController@store')->name('klaim.store')->middleware('can:create-klaim');

// Jurnal
Route::get('jurnal', 'JurnalController@index')->name('jurnal.index')->middleware('can:read-jurnal');
Route::post('jurnal', 'JurnalController@post')->name('jurnal.post')->middleware('can:read-jurnal');


// User Management
Route::get('account', 'AccountController@index')->name('account.userIndex')->middleware('can:read-user');
Route::get('account/add', 'AccountController@tambah')->name('account.userTambah')->middleware('can:create-user');
Route::post('account/add', 'AccountController@store')->name('account.userStore')->middleware('can:create-user');
Route::get('account/edit/{id}', 'AccountController@ubah')->name('account.userUbah')->middleware('can:update-user');
Route::post('account/edit', 'AccountController@update')->name('account.userUpdate')->middleware('can:update-user');
Route::get('account/reset/{id}', 'AccountController@reset');
Route::get('account/actived/{id}', 'AccountController@activate');

Route::get('account/role', 'AccountController@role')->name('account.roleIndex')->middleware('can:read-role');
Route::get('account/role/create', 'AccountController@roleCreate')->name('account.roleCreate')->middleware('can:create-role');
Route::post('account/role/create', 'AccountController@rolePost')->name('account.rolePost')->middleware('can:create-role');
Route::get('account/role/{slug}', 'AccountController@roleUbah')->name('account.roleUbah')->middleware('can:update-role');
Route::post('account/role/update', 'AccountController@roleEdit')->name('account.roleEdit')->middleware('can:update-role');

Route::get('account/profile', 'AccountController@profile')->name('account.profile');
Route::post('account/profile', 'AccountController@postProfile')->name('account.postProfile');
Route::post('account/profile/password', 'AccountController@changePassword')->name('account.password');
//User Management
