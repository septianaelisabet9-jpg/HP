<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Layanan - Laundry</title>
</head>
<body>
    <h2>Form Tambah Layanan</h2>
    
    <form action="/simpan-layanan" method="POST">
        @csrf
        <label>Nama Layanan:</label><br>
        <input type="text" name="nama_layanan" required><br><br>

        <label>Jenis:</label><br>
        <input type="text" name="jenis" required><br><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" required><br><br>

        <button type="submit">Simpan Layanan</button>
        <a href="/layanan">Batal</a>
    </form>
</body>
</html>