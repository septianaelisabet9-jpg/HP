<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi - Laundry</title>
</head>
<body>
    <h2>Form Tambah Transaksi</h2>
    
    <!-- PERBAIKAN DI SINI: ganti action ke /simpan_transaksi -->
    <form action="/simpan_transaksi" method="POST">
        @csrf
        <label>Pilih Pelanggan:</label><br>
        <select name="id_pelanggan" required>
            <option value="">-- Pilih Pelanggan --</option>
            @foreach($pelanggan as $p)
                <option value="{{ $p->id }}">{{ $p->nama_pelanggan }}</option>
            @endforeach
        </select><br><br>

        <label>Pilih Layanan:</label><br>
        <select name="id_layanan" required>
            <option value="">-- Pilih Layanan --</option>
            @foreach($layanan as $l)
                <option value="{{ $l->id }}">{{ $l->nama_layanan }} (Rp {{ number_format($l->harga, 0, ',', '.') }})</option>
            @endforeach
        </select><br><br>

        

        <label>Berat Cucian (Kg / Jumlah):</label><br>
        <input type="number" step="0.1" name="jumlah" required><br><br>

        <button type="submit">Simpan Transaksi</button>
        <a href="/transaksi">Batal</a>
    </form>
</body>
</html>