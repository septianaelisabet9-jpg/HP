<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laundry;

// --- AUTH & HOME ---
Route::get('/', 'App\Http\Controllers\Laundry@index');
Route::post('/login', 'App\Http\Controllers\Laundry@aksilogin');
Route::get('/home', 'App\Http\Controllers\Laundry@home');
Route::get('/logout', 'App\Http\Controllers\Laundry@logout');

// --- ROUTE PELANGGAN ---
Route::get('/pelanggan', 'App\Http\Controllers\Laundry@indexPelanggan');
Route::get('/tambah_pelanggan', 'App\Http\Controllers\Laundry@tambahPelanggan');
Route::get('/tambah-pelanggan', 'App\Http\Controllers\Laundry@tambahPelanggan');
Route::post('/simpan_pelanggan', 'App\Http\Controllers\Laundry@simpanPelanggan');
Route::post('/simpan-pelanggan', 'App\Http\Controllers\Laundry@simpanPelanggan');
Route::get('/hapus_pelanggan/{id}', 'App\Http\Controllers\Laundry@hapusPelanggan');
Route::get('/pelanggan/pdf', 'App\Http\Controllers\Laundry@pdfPelanggan');
Route::get('/pelanggan/excel', 'App\Http\Controllers\Laundry@excelPelanggan');

// --- ROUTE LAYANAN ---
Route::get('/layanan', 'App\Http\Controllers\Laundry@indexLayanan');
Route::get('/tambah_layanan', 'App\Http\Controllers\Laundry@tambahLayanan');
Route::get('/tambah-layanan', 'App\Http\Controllers\Laundry@tambahLayanan');
Route::post('/simpan_layanan', 'App\Http\Controllers\Laundry@simpanLayanan');
Route::post('/simpan-layanan', 'App\Http\Controllers\Laundry@simpanLayanan');
Route::get('/hapus_layanan/{id}', 'App\Http\Controllers\Laundry@hapusLayanan');
Route::get('/layanan/pdf', 'App\Http\Controllers\Laundry@pdfLayanan');
Route::get('/layanan/excel', 'App\Http\Controllers\Laundry@excelLayanan');

// --- ROUTE TRANSAKSI ---
Route::get('/transaksi', 'App\Http\Controllers\Laundry@indexTransaksi');
Route::get('/tambah_transaksi', 'App\Http\Controllers\Laundry@tambahTransaksi');
Route::get('/tambah-transaksi', 'App\Http\Controllers\Laundry@tambahTransaksi');
Route::post('/simpan_transaksi', 'App\Http\Controllers\Laundry@simpanTransaksi');
Route::post('/simpan-transaksi', 'App\Http\Controllers\Laundry@simpanTransaksi');
Route::get('/hapus_transaksi/{id}', 'App\Http\Controllers\Laundry@hapusTransaksi');
Route::get('/transaksi/pdf', 'App\Http\Controllers\Laundry@pdfTransaksi');
Route::get('/transaksi/excel', 'App\Http\Controllers\Laundry@excelTransaksi');

// --- ROUTE PEMBAYARAN & NOTA ---
Route::get('/pembayaran', 'App\Http\Controllers\Laundry@indexPembayaran');
Route::get('/tambah_pembayaran', 'App\Http\Controllers\Laundry@tambahPembayaran');
Route::get('/tambah-pembayaran', 'App\Http\Controllers\Laundry@tambahPembayaran');
Route::post('/simpan_pembayaran', 'App\Http\Controllers\Laundry@simpanPembayaran');
Route::post('/simpan-pembayaran', 'App\Http\Controllers\Laundry@simpanPembayaran');
Route::get('/cetak_nota/{id}', 'App\Http\Controllers\Laundry@cetakNota');

// --- ROUTE LAPORAN ---
Route::get('/laporan', 'App\Http\Controllers\Laundry@laporan');

// --- ROUTE KARYAWAN & TKRY ---
Route::get('/karyawan', 'App\Http\Controllers\Laundry@karyawan');
Route::get('/tkry', 'App\Http\Controllers\Laundry@tkry')->name('tkry');
Route::post('/aksi_tkry', 'App\Http\Controllers\Laundry@aksi_tkry')->name('aksi_tkry');
Route::post('/aksi_tkry', 'App\Http\Controllers\Laundry@aksi_tkry');
Route::get('/edit_karyawan/{id}', 'App\Http\Controllers\Laundry@editKaryawan');
Route::post('/edit_karyawan_aksi/{id}', 'App\Http\Controllers\Laundry@editKaryawanAksi');
Route::get('/hapus_karyawan/{id}', 'App\Http\Controllers\Laundry@hapusKaryawan');
Route::post('/hapus_karyawan/{id}', 'App\Http\Controllers\Laundry@hapusKaryawan');