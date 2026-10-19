<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pembayaran</title>
</head>
<body>
    <h2>Form Input Pembayaran</h2>

    <form action="pembayaran.php" method="POST" enctype="multipart/form-data">
        <label for="transaksi">Pilih Transaksi:</label><br>
        <select id="transaksi" name="transaksi_id" required>
            <option value="">-- Pilih Transaksi --</option>
            <option value="1">#TRX-001 - Andi (Total: Rp 25.000)</option>
            <option value="2">#TRX-002 - Budi (Total: Rp 30.000)</option>
        </select>
        <br><br>

        <label for="tanggal">Tanggal Bayar:</label><br>
        <input type="datetime-local" id="tanggal" name="tanggal_bayar" required>
        <br><br>

        <label for="jumlah">Jumlah Bayar (Rp):</label><br>
        <input type="number" id="jumlah" name="jumlah_bayar" placeholder="Contoh: 25000" required>
        <br><br>

        <label for="metode">Metode Pembayaran:</label><br>
        <select id="metode" name="metode_pembayaran" required>
            <option value="cash">Tunai (Cash)</option>
            <option value="qris">QRIS</option>
            <option value="transfer">Transfer Bank</option>
        </select>
        <br><br>

        <label for="status">Status Pembayaran:</label><br>
        <select id="status" name="status_pembayaran" required>
            <option value="lunas">Lunas</option>
            <option value="dp">DP (Uang Muka)</option>
        </select>
        <br><br>

        <label for="bukti">Bukti Transfer (Opsional):</label><br>
        <input type="file" id="bukti" name="bukti_bayar" accept="image/*">
        <br><br>

        <button type="submit">Simpan Pembayaran</button>
        <a href="pembayaran.php">Batal</a>
    </form>
</body>
</html>