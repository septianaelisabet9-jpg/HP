<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransaksiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('transaksi')
            ->join('pelanggan', 'transaksi.id_pelanggan', '=', 'pelanggan.id')
            ->leftJoin('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.id_transaksi')
            ->leftJoin('layanan', 'detail_transaksi.id_layanan', '=', 'layanan.id')
            ->select(
                'transaksi.id',
                'pelanggan.nama_pelanggan',
                'layanan.nama_layanan',
                'detail_transaksi.jumlah as berat',
                'transaksi.total_bayar',
                'transaksi.status_laundry',
                'transaksi.status_bayar',
                'transaksi.tgl_transaksi'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            "ID Transaksi",
            "Nama Pelanggan",
            "Layanan",
            "Berat (Kg)",
            "Total Bayar",
            "Status Laundry",
            "Status Bayar",
            "Tanggal Transaksi"
        ];
    }
}