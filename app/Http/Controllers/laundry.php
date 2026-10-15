<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Database;
use Illuminate\Support\Facades\DB;
use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;
use TCPDF;
use App\Exports\PelangganExport;
use App\Exports\LayananExport;

class Laundry extends Controller
{
    public function index()
    {
        return view("login");
    }

    public function aksilogin(Request $request)
    {
        $username = $request->input("username");
        $password = $request->input("password");

        $where = array(
            'name' => $username,
            'password' => $password
        );

        $db = new Database();
        $user = $db->pull('users', $where);

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
        } else {
            return redirect('/');
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }

    // Pelanggan
    public function indexPelanggan()
    {
        if (session('u')) {
            $db = new Database();
            $data['pelanggan'] = $db->tampil('pelanggan');
            return view('pelanggan', $data);
        } else {
            return redirect('/');
        }
    }

    public function tambahPelanggan()
    {
        return view('tambah_pelanggan');
    }

    public function simpanPelanggan(Request $request)
    {
        DB::table('pelanggan')->insert([
            'nama_pelanggan' => $request->input('nama_pelanggan'),
            'no_tlpn' => $request->input('no_tlpn'),
            'alamat' => $request->input('alamat'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/pelanggan');
    }

    public function hapusPelanggan($id)
    {
        DB::table('pelanggan')->where('id', $id)->delete();
        return redirect('/pelanggan');
    }

    // Layanan
    public function indexLayanan()
    {
        if (session('u')) {
            $db = new Database();
            $data['layanan'] = $db->tampil('layanan');
            return view('layanan', $data);
        } else {
            return redirect('/');
        }
    }

    public function tambahLayanan()
    {
        return view('tambah_layanan');
    }

    public function simpanLayanan(Request $request)
    {
        DB::table('layanan')->insert([
            'nama_layanan' => $request->input('nama_layanan'),
            'jenis' => $request->input('jenis'),
            'harga' => $request->input('harga'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/layanan');
    }

    public function hapusLayanan($id)
    {
        DB::table('layanan')->where('id', $id)->delete();
        return redirect('/layanan');
    }

    // Transaksi
    public function indexTransaksi()
    {
        if (session('u')) {
            $data['transaksi'] = DB::table('transaksi')
                ->join('pelanggan', 'transaksi.id_pelanggan', '=', 'pelanggan.id')
                ->leftJoin('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.id_transaksi')
                ->leftJoin('layanan', 'detail_transaksi.id_layanan', '=', 'layanan.id')
                ->select(
                    'transaksi.*', 
                    'pelanggan.nama_pelanggan', 
                    'layanan.nama_layanan', 
                    'detail_transaksi.jumlah as berat', 
                    'detail_transaksi.subtotal'
                )
                ->get();
            return view('transaksi', $data);
        } else {
            return redirect('/');
        }
    }

    public function tambahTransaksi()
    {
        if (session('u')) {
            $data['pelanggan'] = DB::table('pelanggan')->get();
            $data['layanan'] = DB::table('layanan')->get();
            return view('tambah_transaksi', $data);
        } else {
            return redirect('/');
        }
    }

    public function simpanTransaksi(Request $request)
    {
        $layanan = DB::table('layanan')->where('id', $request->input('id_layanan'))->first();
        $berat = $request->input('jumlah');
        $subtotal = $layanan->harga * $berat;

        $id_transaksi = DB::table('transaksi')->insertGetId([
            'id_pelanggan' => $request->input('id_pelanggan'),
            'id_users' => session('id_user') ?? 1,
            'tgl_transaksi' => now(),
            'tgl_selesai' => now()->addDays(3),
            'status_laundry' => 'Proses',
            'status_bayar' => 'Belum Lunas',
            'total_bayar' => $subtotal,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('detail_transaksi')->insert([
            'id_transaksi' => $id_transaksi,
            'id_layanan' => $request->input('id_layanan'),
            'jumlah' => $berat,
            'subtotal' => $subtotal,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/transaksi');
    }

    public function hapusTransaksi($id)
    {
        DB::table('detail_transaksi')->where('id_transaksi', $id)->delete();
        DB::table('transaksi')->where('id', $id)->delete();
        
        return redirect('/transaksi');
    }

    // Print Window
    public function printTransaksi()
    {
        if (session('u')) {
            $data['transaksi'] = DB::table('transaksi')
                ->join('pelanggan', 'transaksi.id_pelanggan', '=', 'pelanggan.id')
                ->leftJoin('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.id_transaksi')
                ->leftJoin('layanan', 'detail_transaksi.id_layanan', '=', 'layanan.id')
                ->select(
                    'transaksi.*', 
                    'pelanggan.nama_pelanggan', 
                    'layanan.nama_layanan', 
                    'detail_transaksi.jumlah as berat', 
                    'detail_transaksi.subtotal'
                )
                ->get();
            return view('print_transaksi', $data);
        } else {
            return redirect('/');
        }
    }

    // Export PDF
    public function pdfTransaksi()
    {
        if (session('u')) {
            $transaksi = DB::table('transaksi')
                ->join('pelanggan', 'transaksi.id_pelanggan', '=', 'pelanggan.id')
                ->leftJoin('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.id_transaksi')
                ->leftJoin('layanan', 'detail_transaksi.id_layanan', '=', 'layanan.id')
                ->select(
                    'transaksi.*', 
                    'pelanggan.nama_pelanggan', 
                    'layanan.nama_layanan', 
                    'detail_transaksi.jumlah as berat', 
                    'detail_transaksi.subtotal'
                )
                ->get();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Sistem Laundry');
            $pdf->SetTitle('Laporan Transaksi');
            
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage();

            $html = '<h2>LAPORAN TRANSAKSI LAUNDRY</h2>';
            $html .= '<p>Tanggal: ' . date('d-m-Y H:i') . '</p>';
            $html .= '<table border="1" cellpadding="5" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Layanan</th>
                                <th>Berat</th>
                                <th>Total Bayar</th>
                                <th>Status Laundry</th>
                            </tr>
                        </thead>
                        <tbody>';
            
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
            $html .= '</tbody></table>';

            $pdf->writeHTML($html, true, false, true, false, '');
            
            // Parameter 'D' memaksa browser langsung mendownload file PDF-nya
            $pdf->Output('laporan-transaksi-' . date('Y-m-d') . '.pdf', 'D'); 
            exit;
        } else {
            return redirect('/');
        }
    }

    // Export Excel
    public function excelTransaksi()
    {
        if (session('u')) {
            return Excel::download(new TransaksiExport, 'laporan-transaksi-' . date('Y-m-d') . '.xlsx');
        } else {
            return redirect('/');
        }
    }

    // --- PELANGGAN EXPORT & PDF ---
    public function pdfPelanggan()
    {
        if (session('u')) {
            $pelanggan = DB::table('pelanggan')->get();
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Sistem Laundry');
            $pdf->SetTitle('Laporan Pelanggan');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage();

            $html = '<h2 style="text-align:center;">Laporan Data Pelanggan</h2>';
            $html .= '<table border="1" cellpadding="5" cellspacing="0"><thead><tr><th>No</th><th>Nama</th><th>No Telepon</th><th>Alamat</th></tr></thead><tbody>';
            $no = 1;
            foreach ($pelanggan as $p) {
                $html .= '<tr><td>' . $no++ . '</td><td>' . $p->nama_pelanggan . '</td><td>' . $p->no_tlpn . '</td><td>' . $p->alamat . '</td></tr>';
            }
            $html .= '</tbody></table>';

            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('laporan-pelanggan.pdf', 'D');
            exit;
        } else {
            return redirect('/');
        }
    }

    public function excelPelanggan()
    {
        if (session('u')) {
            return Excel::download(new PelangganExport, 'laporan-pelanggan-' . date('Y-m-d') . '.xlsx');
        } else {
            return redirect('/');
        }
    }

    // --- LAYANAN EXPORT & PDF ---
    public function pdfLayanan()
    {
        if (session('u')) {
            $layanan = DB::table('layanan')->get();
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Sistem Laundry');
            $pdf->SetTitle('Laporan Layanan');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage();

            $html = '<h2 style="text-align:center;">Laporan Data Layanan</h2>';
            $html .= '<table border="1" cellpadding="5" cellspacing="0"><thead><tr><th>No</th><th>Nama Layanan</th><th>Jenis</th><th>Harga</th></tr></thead><tbody>';
            $no = 1;
            foreach ($layanan as $l) {
                $html .= '<tr><td>' . $no++ . '</td><td>' . $l->nama_layanan . '</td><td>' . $l->jenis . '</td><td>Rp ' . number_format($l->harga, 0, ',', '.') . '</td></tr>';
            }
            $html .= '</tbody></table>';

            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('laporan-layanan.pdf', 'D');
            exit;
        } else {
            return redirect('/');
        }
    }

    public function excelLayanan()
    {
        if (session('u')) {
            return Excel::download(new LayananExport, 'laporan-layanan-' . date('Y-m-d') . '.xlsx');
        } else {
            return redirect('/');
        }
    }
}