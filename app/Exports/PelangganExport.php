<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PelangganExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('pelanggan')->select('id', 'nama_pelanggan', 'no_tlpn', 'alamat', 'created_at')->get();
    }

    public function headings(): array
    {
        return ["ID", "Nama Pelanggan", "No Telepon", "Alamat", "Tanggal Bergabung"];
    }
}