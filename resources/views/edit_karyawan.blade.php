<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Karyawan</title>
</head>
<body>

    <h2>Edit Data Karyawan</h2>

    <p><a href="/karyawan">Kembali ke Data Karyawan</a></p>

    <form action="/edit_karyawan_aksi/{{ $karyawan->id_karyawan }}" method="POST">
        @csrf

        <label>Nama Karyawan:</label><br>
        <input type="text" name="nama_kry" value="{{ $karyawan->nama_kry }}" required><br><br>

        <label>Alamat:</label><br>
        <input type="text" name="alamat_kry" value="{{ $karyawan->alamat_kry }}" required><br><br>

        <label>Jenis Kelamin:</label><br>
        <input type="radio" name="jk_kry" value="L" {{ $karyawan->jk_kry == 'L' ? 'checked' : '' }}> Laki-laki
        <input type="radio" name="jk_kry" value="P" {{ $karyawan->jk_kry == 'P' ? 'checked' : '' }}> Perempuan
        <br><br>

        <button type="submit">Simpan Perubahan</button>
    </form>

</body>
</html>