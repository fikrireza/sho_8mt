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
Route::group(['middleware' => ['administrator']], function () {

  Route::get('home', 'DashboardController@index')->name('dashboard');

  // Daftar BMT
  Route::get('daftar', 'DaftarBmtController@index')->name('daftar.index');
  Route::get('daftar/tambah', 'DaftarBmtController@tambah')->name('daftar.tambah');
  Route::post('daftar/tambah', 'DaftarBmtController@store')->name('daftar.store');
  Route::get('daftar/ubah/{id}', 'DaftarBmtController@ubah')->name('daftar.ubah');
  Route::post('daftar/ubah', 'DaftarBmtController@edit')->name('daftar.edit');

  // Anggota BMT
  Route::get('anggota', 'DaftarAnggotaController@index')->name('anggota.index');
  Route::get('anggota/tambah', 'DaftarAnggotaController@tambah')->name('anggota.tambah');
  Route::post('anggota/tambah', 'DaftarAnggotaController@store')->name('anggota.store');
  Route::get('anggota/ubah/{id}', 'DaftarAnggotaController@ubah')->name('anggota.ubah');
  Route::post('anggota/ubah', 'DaftarAnggotaController@edit')->name('anggota.edit');
});
