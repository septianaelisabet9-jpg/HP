<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan</title>
</head>
<body>
    <h2>Laporan Pendapatan Laundry</h2>

   
<form action="/laporan" method="GET">
    <label for="tgl_mulai">Tanggal Mulai:</label>
    <input type="date" id="tgl_mulai" name="tgl_mulai" required>

    <label for="tgl_selesai">Tanggal Selesai:</label>
    <input type="date" id="tgl_selesai" name="tgl_selesai" required>

    <button type="submit">Filter Laporan</button>
</form>
    <br>

    <h3>Total Pemasukan: Rp 40.000</h3>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Tanggal Bayar</th>
            <th>Kode Transaksi</th>
            <th>Pelanggan</th>
            <th>Metode</th>
            <th>Jumlah Bayar</th>
        </tr>
        <tr>
            <td>1</td>
            <td>2026-03-28 10:30</td>
            <td>#TRX-001</td>
            <td>Andi</td>
            <td>CASH</td>
            <td>Rp 25.000</td>
        </tr>
        <tr>
            <td>2</td>
            <td>2026-03-28 11:15</td>
            <td>#TRX-002</td>
            <td>Budi</td>
            <td>QRIS</td>
            <td>Rp 15.000</td>
        </tr>
    </table>
</body>
</html>