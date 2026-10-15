<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Database extends Model
{
    protected $guarded = ['id'];

    // Fungsi universal untuk mengambil satu data (biasanya dipakai untuk login / cari data)
    public function pull($tabel, $kondisi)
    {
        return DB::table($tabel)->where($kondisi)->first();
    }

    // Fungsi universal untuk mengambil seluruh data dari tabel
    public function tampil($tabel)
    {
        return DB::table($tabel)->get();
    }
}