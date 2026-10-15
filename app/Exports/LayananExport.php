<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LayananExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('layanan')->select('id', 'nama_layanan', 'jenis', 'harga', 'created_at')->get();
    }

    public function headings(): array
    {
        return ["ID", "Nama Layanan", "Jenis", "Harga (Rp)", "Tanggal Dibuat"];
    }
}