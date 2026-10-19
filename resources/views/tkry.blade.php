<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Karyawan Laundry</title>
</head>
<body>
    <h1>Input Karyawan</h1>

    <form action="/aksi_tkry" method="POST">
        @csrf

        Username: 
        <input type="text" name="us">
        <br>

        Password: 
        <input type="password" name="ps">
        <br>

        Email: 
        <input type="email" name="email">
        <br>

        Level:
        <select name="le">
            <option value="1">Admin</option>
            <option value="2">Karyawan</option>
            <option value="3">Pelanggan</option>
        </select>
        <br>

        Nama Karyawan:
        <input type="text" name="s">
        <br>

        Alamat Karyawan:
        <input type="text" name="b">
        <br>

        Jenis Kelamin:
        <input type="radio" name="jk" value="L"> Laki-laki
        <input type="radio" name="jk" value="P"> Perempuan
        <br>

    

        <button type="submit">Simpan</button>
    </form>
</body>
</html>