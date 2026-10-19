<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\TransaksiExport;
use App\Exports\PelangganExport;
use App\Exports\LayananExport;
use Maatwebsite\Excel\Facades\Excel;
use TCPDF;

class Laundry extends Controller
{
    // --- AUTH & NAVIGASI ---
    public function index()
    {
        return view("login");
    }

    public function aksilogin(Request $request)
    {
        $user = DB::table('users')
            ->where('name', $request->input('username'))
            ->where('password', $request->input('password'))
            ->first();

        if ($user) {
            session(['u' => $user->name, 'id_user' => $user->id]);
            return redirect('/home');
        } else {
            return redirect('/')->with('error', 'Username atau Password salah!');
        }
    }

    public function home()
    {
        if (session('u')) {
            return view('home');
        }
        return redirect('/');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }

    // --- PELANGGAN ---
    public function indexPelanggan()
    {
        if (!session('u')) return redirect('/');

        $data['pelanggan'] = DB::table('pelanggan')->get();
        return view('pelanggan', $data);
    }

    public function tambahPelanggan()
    {
        return view('tambah_pelanggan');
    }

    public function simpanPelanggan(Request $request)
    {
        DB::table('pelanggan')->insert([
            'nama_pelanggan' => $request->input('nama_pelanggan'),
            'no_tlpn'        => $request->input('no_tlpn'),
            'alamat'         => $request->input('alamat'),
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect('/pelanggan');
    }

    public function hapusPelanggan($id)
    {
        DB::table('pelanggan')->where('id', $id)->delete();
        return redirect('/pelanggan');
    }

    public function pdfPelanggan()
    {
        if (!session('u')) return redirect('/');

        $pelanggan = DB::table('pelanggan')->get();
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();

        $html = '<h2 style="text-align:center;">Laporan Data Pelanggan</h2>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0"><tr><th>No</th><th>Nama</th><th>No Telepon</th><th>Alamat</th></tr>';
        $no = 1;
        foreach ($pelanggan as $p) {
            $html .= '<tr><td>' . $no++ . '</td><td>' . $p->nama_pelanggan . '</td><td>' . $p->no_tlpn . '</td><td>' . $p->alamat . '</td></tr>';
        }
        $html .= '</table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('laporan-pelanggan.pdf', 'D');
        exit;
    }

    public function excelPelanggan()
    {
        if (!session('u')) return redirect('/');
        return Excel::download(new PelangganExport, 'laporan-pelanggan-' . date('Y-m-d') . '.xlsx');
    }

    // --- LAYANAN ---
    public function indexLayanan()
    {
        if (!session('u')) return redirect('/');

        $data['layanan'] = DB::table('layanan')->get();
        return view('layanan', $data);
    }

    public function tambahLayanan()
    {
        return view('tambah_layanan');
    }

    public function simpanLayanan(Request $request)
    {
        DB::table('layanan')->insert([
            'nama_layanan' => $request->input('nama_layanan'),
            'jenis'        => $request->input('jenis'),
            'harga'        => $request->input('harga'),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect('/layanan');
    }

    public function hapusLayanan($id)
    {
        DB::table('layanan')->where('id', $id)->delete();
        return redirect('/layanan');
    }

    public function pdfLayanan()
    {
        if (!session('u')) return redirect('/');

        $layanan = DB::table('layanan')->get();
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();

        $html = '<h2 style="text-align:center;">Laporan Data Layanan</h2>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0"><tr><th>No</th><th>Nama Layanan</th><th>Jenis</th><th>Harga</th></tr>';
        $no = 1;
        foreach ($layanan as $l) {
            $html .= '<tr><td>' . $no++ . '</td><td>' . $l->nama_layanan . '</td><td>' . $l->jenis . '</td><td>Rp ' . number_format($l->harga, 0, ',', '.') . '</td></tr>';
        }
        $html .= '</table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('laporan-layanan.pdf', 'D');
        exit;
    }

    public function excelLayanan()
    {
        if (!session('u')) return redirect('/');
        return Excel::download(new LayananExport, 'laporan-layanan-' . date('Y-m-d') . '.xlsx');
    }

    // --- TRANSAKSI ---
    public function indexTransaksi()
    {
        if (!session('u')) return redirect('/');

        $data['transaksi'] = DB::table('transaksi')
            ->join('pelanggan', 'transaksi.id_pelanggan', '=', 'pelanggan.id')
            ->leftJoin('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.id_transaksi')
            ->leftJoin('layanan', 'detail_transaksi.id_layanan', '=', 'layanan.id')
            ->select('transaksi.*', 'pelanggan.nama_pelanggan', 'layanan.nama_layanan', 'detail_transaksi.jumlah as berat')
            ->get();

        return view('transaksi', $data);
    }

    public function tambahTransaksi()
    {
        if (!session('u')) return redirect('/');

        $data['pelanggan'] = DB::table('pelanggan')->get();
        $data['layanan']   = DB::table('layanan')->get();
        return view('tambah_transaksi', $data);
    }

    public function simpanTransaksi(Request $request)
    {
        $layanan = DB::table('layanan')->where('id', $request->input('id_layanan'))->first();
        $berat   = $request->input('jumlah');
        $total   = ($layanan ? $layanan->harga : 0) * $berat;

        $id_transaksi = DB::table('transaksi')->insertGetId([
            'id_pelanggan'   => $request->input('id_pelanggan'),
            'id_users'       => session('id_user') ?? 1,
            'tgl_transaksi'  => now(),
            'tgl_selesai'    => now()->addDays(3),
            'status_laundry' => 'Proses',
            'status_bayar'   => 'Belum Lunas',
            'total_bayar'    => $total,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        DB::table('detail_transaksi')->insert([
            'id_transaksi' => $id_transaksi,
            'id_layanan'   => $request->input('id_layanan'),
            'jumlah'       => $berat,
            'subtotal'     => $total,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect('/transaksi');
    }

    public function hapusTransaksi($id)
    {
        DB::table('detail_transaksi')->where('id_transaksi', $id)->delete();
        DB::table('transaksi')->where('id', $id)->delete();
        return redirect('/transaksi');
    }

    public function pdfTransaksi()
    {
        if (!session('u')) return redirect('/');

        $transaksi = DB::table('transaksi')
            ->join('pelanggan', 'transaksi.id_pelanggan', '=', 'pelanggan.id')
            ->leftJoin('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.id_transaksi')
            ->leftJoin('layanan', 'detail_transaksi.id_layanan', '=', 'layanan.id')
            ->select('transaksi.*', 'pelanggan.nama_pelanggan', 'layanan.nama_layanan', 'detail_transaksi.jumlah as berat')
            ->get();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();

        $html = '<h2>LAPORAN TRANSAKSI LAUNDRY</h2>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0"><tr><th>No</th><th>Pelanggan</th><th>Layanan</th><th>Berat</th><th>Total</th><th>Status</th></tr>';
        
        $no = 1;
        foreach ($transaksi as $t) {
            $html .= '<tr>
                        <td>' . $no++ . '</td>
                        <td>' . $t->nama_pelanggan . '</td>
                        <td>' . $t->nama_layanan . '</td>
                        <td>' . $t->berat . ' kg</td>
                        <td>Rp ' . number_format($t->total_bayar, 0, ',', '.') . '</td>
                        <td>' . $t->status_laundry . '</td>
                      </tr>';
        }
        $html .= '</table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('laporan-transaksi.pdf', 'D');
        exit;
    }

    public function excelTransaksi()
    {
        if (!session('u')) return redirect('/');
        return Excel::download(new TransaksiExport, 'laporan-transaksi-' . date('Y-m-d') . '.xlsx');
    }

    // --- PEMBAYARAN ---
    public function indexPembayaran()
    {
        if (!session('u')) return redirect('/');

        $pembayaran = DB::table('pembayaran')->get();

        foreach ($pembayaran as $p) {
            $transaksi = DB::table('transaksi')->where('id', $p->id_transaksi)->first();
            if ($transaksi) {
                $pelanggan = DB::table('pelanggan')->where('id', $transaksi->id_pelanggan)->first();
                $p->nama_pelanggan = $pelanggan ? $pelanggan->nama_pelanggan : '-';
            } else {
                $p->nama_pelanggan = '-';
            }
        }

        return view('pembayaran', [
            'pembayaran' => $pembayaran,
            'laporan'    => $pembayaran
        ]);
    }

    public function tambahPembayaran()
    {
        if (!session('u')) return redirect('/');

        $data['transaksi'] = DB::table('transaksi')
            ->join('pelanggan', 'transaksi.id_pelanggan', '=', 'pelanggan.id')
            ->where('transaksi.status_bayar', 'Belum Lunas')
            ->select('transaksi.*', 'pelanggan.nama_pelanggan')
            ->get();

        return view('tambah_pembayaran', $data);
    }

    public function simpanPembayaran(Request $request)
    {
        // Otomatis ambil nominal total_bayar dari tabel transaksi
        $transaksi = DB::table('transaksi')->where('id', $request->input('transaksi_id'))->first();
        $totalTagihan = $transaksi ? $transaksi->total_bayar : 0;

        DB::table('pembayaran')->insert([
            'id_transaksi'      => $request->input('transaksi_id'),
            'tgl_bayar'         => now(), // Otomatis tanggal hari ini
            'jmlh_bayar'        => $totalTagihan, // Otomatis terisi nominal tagihan
            'metode_pembayaran' => $request->input('metode_pembayaran'),
            'id_karyawan'       => session('id_user') ?? 1,
        ]);

        // Otomatis ubah status_bayar transaksi menjadi Lunas
        DB::table('transaksi')
            ->where('id', $request->input('transaksi_id'))
            ->update(['status_bayar' => 'Lunas']);

        return redirect('/pembayaran');
    }

    // --- LAPORAN ---
    public function laporan(Request $request)
    {
        if (!session('u')) return redirect('/');

        $tgl_mulai   = $request->input('tgl_mulai');
        $tgl_selesai = $request->input('tgl_selesai');

        $query = DB::table('pembayaran');

        if ($tgl_mulai && $tgl_selesai) {
            $query->whereBetween('tgl_bayar', [$tgl_mulai, $tgl_selesai]);
        }

        $pembayaran = $query->get();

        foreach ($pembayaran as $p) {
            $transaksi = DB::table('transaksi')->where('id', $p->id_transaksi)->first();
            if ($transaksi) {
                $pelanggan = DB::table('pelanggan')->where('id', $transaksi->id_pelanggan)->first();
                $p->nama_pelanggan = $pelanggan ? $pelanggan->nama_pelanggan : '-';
            } else {
                $p->nama_pelanggan = '-';
            }
        }

        $total_pemasukan = $pembayaran->sum('jmlh_bayar');

        return view('laporan', [
            'laporan'         => $pembayaran,
            'total_pemasukan' => $total_pemasukan
        ]);
    }

    // --- KARYAWAN & TKRY ---
    public function karyawan()
    {
        if (!session('u')) return redirect('/');

        $data['karyawan'] = DB::table('karyawan')
            ->leftJoin('users', 'karyawan.id_user', '=', 'users.id')
            ->select('karyawan.*', 'users.name as username', 'users.email')
            ->get();

        return view('karyawan', $data);
    }

    public function tkry()
    {
        if (!session('u')) return redirect('/');

        $data['layanan'] = DB::table('layanan')->get();
        return view('Tkry', $data);
    }

    public function aksi_tkry(Request $request)
    {
        $userId = DB::table('users')->insertGetId([
            'name'     => $request->input('us'),
            'password' => $request->input('ps'),
            'email'    => $request->input('email'),
            'level'    => $request->input('le')
        ]);

        DB::table('karyawan')->insert([
            'id_user'    => $userId,
            'nama_kry'   => $request->input('s'),
            'alamat_kry' => $request->input('b'),
            'jk_kry'     => $request->input('jk')
        ]);

        return redirect('/karyawan');
    }

    public function editKaryawan($id)
    {
        if (!session('u')) return redirect('/');

        $data['karyawan'] = DB::table('karyawan')
            ->leftJoin('users', 'karyawan.id_user', '=', 'users.id')
            ->select('karyawan.*', 'users.name as username', 'users.email')
            ->where('karyawan.id_karyawan', $id)
            ->first();

        return view('edit_karyawan', $data);
    }

    public function editKaryawanAksi(Request $request, $id)
    {
        DB::table('karyawan')->where('id_karyawan', $id)->update([
            'nama_kry'   => $request->input('nama_kry'),
            'alamat_kry' => $request->input('alamat_kry'),
            'jk_kry'     => $request->input('jk_kry')
        ]);

        return redirect('/karyawan');
    }

    public function hapusKaryawan($id)
    {
        DB::table('karyawan')->where('id_karyawan', $id)->delete();
        return redirect('/karyawan');
    }
}