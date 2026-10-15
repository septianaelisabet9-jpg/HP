<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi - Laundry</title>
</head>
<body>
    <h2>Data Transaksi Laundry</h2>

    
    <button type="button" onclick="window.print()">Window Print</button>
    <button type="button"><a href="/transaksi/pdf" target="_blank">📄 Download PDF</a></button>
    <button><a href="/transaksi/excel">📊 Export Excel</a></button>
   
    <br><br>

    <button>
    <a href="/tambah-transaksi">Tambah Transaksi Baru</a>
    </button>

    <button>
        <a href="/home">Kembali ke Home</a>
    </button>

    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Layanan</th>
            <th>Berat (kg)</th>
            <th>Total Bayar</th>
            <th>Status Laundry</th>
            <th>Status Bayar</th>
            <th>Aksi</th>
        </tr>
        @foreach($transaksi as $t)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $t->nama_pelanggan }}</td>
            <td>{{ $t->nama_layanan }}</td>
            <td>{{ $t->berat }} kg</td>
            <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
            <td>{{ $t->status_laundry }}</td>
            <td>{{ $t->status_bayar }}</td>
            <td>
                <a href="/hapus-transaksi/{{ $t->id }}" onclick="return confirm('Yakin ingin menghapus transaksi ini?')">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>