<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laundry; 

Route::get('/', 'App\Http\Controllers\laundry@index');
Route::post('/login', 'App\Http\Controllers\laundry@aksilogin');

Route::get('/home', 'App\Http\Controllers\laundry@home');
Route::get('/logout', 'App\Http\Controllers\laundry@logout');

Route::get('/pelanggan', 'App\Http\Controllers\laundry@indexPelanggan');
Route::get('/tambah-pelanggan', 'App\Http\Controllers\laundry@tambahPelanggan');
Route::post('/simpan-pelanggan', 'App\Http\Controllers\laundry@simpanPelanggan');
Route::get('/hapus-pelanggan/{id}', 'App\Http\Controllers\laundry@hapusPelanggan');

Route::get('/layanan', 'App\Http\Controllers\laundry@indexLayanan');
Route::get('/tambah-layanan', 'App\Http\Controllers\laundry@tambahLayanan');
Route::post('/simpan-layanan', 'App\Http\Controllers\laundry@simpanLayanan');
Route::get('/hapus-layanan/{id}', 'App\Http\Controllers\laundry@hapusLayanan');

Route::get('/transaksi', 'App\Http\Controllers\laundry@indexTransaksi');
Route::get('/tambah-transaksi', 'App\Http\Controllers\laundry@tambahTransaksi');
Route::post('/simpan-transaksi', 'App\Http\Controllers\laundry@simpanTransaksi');
Route::get('/hapus-transaksi/{id}', 'App\Http\Controllers\laundry@hapusTransaksi');

Route::get('/transaksi/print', 'App\Http\Controllers\Laundry@printTransaksi');
Route::get('/transaksi/pdf', 'App\Http\Controllers\Laundry@pdfTransaksi');
Route::get('/transaksi/excel', 'App\Http\Controllers\Laundry@excelTransaksi');

Route::get('/pelanggan/pdf', 'App\Http\Controllers\Laundry@pdfPelanggan');
Route::get('/pelanggan/excel', 'App\Http\Controllers\Laundry@excelPelanggan');

Route::get('/layanan/pdf', 'App\Http\Controllers\Laundry@pdfLayanan');
Route::get('/layanan/excel', 'App\Http\Controllers\Laundry@excelLayanan');