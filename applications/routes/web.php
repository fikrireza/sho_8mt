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

Route::get('/', 'Auth\LoginController@showLoginForm')->name('index');

// START Auth
Route::post('login-process', 'Auth\LoginController@loginProcess')->name('login');
Route::get('logout-process', 'Auth\LoginController@logout')->name('auth.logout');
// END Auth

// Middleware backend for pbmt and bmt
// Route::group(['middleware' => ['administrator']], function () {

  Route::get('home', 'DashboardController@index')->name('dashboard');

  // Anggota BMT
  Route::get('anggota', 'DaftarAnggotaController@index')->name('anggota.index');
  Route::get('anggota/tambah', 'DaftarAnggotaController@tambah')->name('anggota.tambah');
  Route::post('anggota/tambah', 'DaftarAnggotaController@store')->name('anggota.store');
  Route::get('anggota/ubah/{id}', 'DaftarAnggotaController@ubah')->name('anggota.ubah');
  Route::post('anggota/ubah', 'DaftarAnggotaController@edit')->name('anggota.edit');

  // Bidang
  Route::get('bidang', 'BidangController@index')->name('bidang.index');
  Route::get('bidang/tambah', 'BidangController@tambah')->name('bidang.tambah');
  Route::post('bidang/tambah', 'BidangController@store')->name('bidang.store');
  Route::get('bidang/ubah/{id}', 'BidangController@ubah')->name('bidang.ubah');
  Route::post('bidang/ubah', 'BidangController@edit')->name('bidang.edit');
  Route::get('bidang/publish/{id}', 'BidangController@publish')->name('bidang.publish');

  // Posisi
  Route::get('posisi', 'PosisiController@index')->name('posisi.index');
  Route::get('posisi/tambah', 'PosisiController@tambah')->name('posisi.tambah');
  Route::post('posisi/tambah', 'PosisiController@store')->name('posisi.store');
  Route::get('posisi/ubah/{id}', 'PosisiController@ubah')->name('posisi.ubah');
  Route::post('posisi/ubah', 'PosisiController@edit')->name('posisi.edit');
  Route::get('posisi/publish/{id}', 'PosisiController@publish')->name('posisi.publish');
// });
