<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan - Laundry</title>
</head>
<body>
    <h2>Form Tambah Pelanggan</h2>
    
    <form action="/simpan_pelanggan" method="POST">
        @csrf
        <label>Nama Pelanggan:</label><br>
        <input type="text" name="nama_pelanggan" required><br><br>

        <label>No Telepon:</label><br>
        <input type="text" name="no_tlpn" required><br><br>

        <label>Alamat:</label><br>
        <textarea name="alamat" rows="4" required></textarea><br><br>

        <button type="submit">Simpan Data</button>
        <a href="/pelanggan">Batal</a>
    </form>
</body>
</html>