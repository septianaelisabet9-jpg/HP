<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Layanan - Laundry</title>
</head>
<body>
    <h2>Data Layanan Laundry</h2>

    <button type="button" onclick="window.print()">Print Window</button>
    <button><a href="/layanan/pdf" target="_blank">Download PDF</a></button>
    <button><a href="/layanan/excel">Export Excel</a></button>
    <br>
    <br>
    <button>
       <a href="/tambah-layanan">Tambah Layanan Baru</a> 
    </button>

    <button>
    <a href="/home">Kembali ke Home</a>
    </button>
    
    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama Layanan</th>
            <th>Jenis</th>
            <th>Harga (Rp)</th>
            <th>Aksi</th>
        </tr>
        @foreach($layanan as $l)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $l->nama_layanan }}</td>
            <td>{{ $l->jenis }}</td>
            <td>Rp {{ number_format($l->harga, 0, ',', '.') }}</td>
            <td>
                <a href="/hapus-layanan/{{ $l->id }}" onclick="return confirm('Yakin ingin menghapus layanan ini?')">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>