<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry</title>
</head>
<body>
    <h2>Dashboard Utama, Selamat Datang {{ session('u') }}!</h2>
    <hr>

    <h3>Menu Navigasi:</h3>
    
    <a href="/pelanggan">Data Pelanggan</a>
    <br>
    <a href="/layanan">Data Layanan</a>
    <br>
    <a href="/transaksi">Data Transaksi</a>
    <br>
    <a href="/karyawan">Data Karyawan</a>
    <br>
    <a href="/pembayaran">Data Pembayaran</a>
    <br>
    <a href="/laporan">Laporan Keuangan</a>
    <br><br>

    <a href="/logout">
        <button type="button">Logout</button>
    </a>
</body>
</html>