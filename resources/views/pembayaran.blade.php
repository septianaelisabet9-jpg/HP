<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pembayaran - Laundry</title>
</head>
<body>
    <h2>Form Input Pembayaran</h2>

    <form action="/simpan_pembayaran" method="POST">
        @csrf
        <label>Pilih Transaksi (Belum Lunas):</label><br>
        <select name="transaksi_id" required>
            <option value="">-- Pilih Transaksi --</option>
            @foreach($transaksi as $t)
                <option value="{{ $t->id }}">
                    #TRX-{{ $t->id }} - {{ $t->nama_pelanggan }} (Rp {{ number_format($t->total_bayar, 0, ',', '.') }})
                </option>
            @endforeach
        </select><br><br>

        <label>Metode Pembayaran:</label><br>
        <select name="metode_pembayaran" required>
            <option value="cash">Tunai (Cash)</option>
            <option value="qris">QRIS</option>
            <option value="transfer">Transfer Bank</option>
        </select><br><br>

        <button type="submit">Simpan Pembayaran Otomatis</button>
        <a href="/pembayaran">Batal</a>
    </form>
</body>
</html>