<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan</title>
</head>
<body>

    <h2>Data Karyawan</h2>

    <p>
        <a href="/home">Kembali ke dashboard</a> | 
        <a href="/tkry"><button type="button">+ Tambah Karyawan Baru</button></a>
    </p>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID Karyawan</th>
            <th>ID User</th>
            <th>Username Akun</th>
            <th>Email</th>
            <th>Nama Karyawan</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th>Layanan</th>
            <th width="120">Aksi</th>
        </tr>
        @foreach($karyawan as $k)
        <tr>
            <td align="center">{{ $k->id_karyawan }}</td>
            <td align="center">{{ $k->id_user }}</td>
            <td>{{ $k->username ?? '-' }}</td>
            <td>{{ $k->email ?? '-' }}</td>
            <td>{{ $k->nama_kry ?? '-' }}</td>
            <td>{{ $k->alamat_kry ?? '-' }}</td>
            <td align="center">{{ $k->jk_kry ?? '-' }}</td>
            <td>{{ $k->nama_layanan ?? '-' }}</td>
            <td align="center">
                <a href="/edit_karyawan/{{ $k->id_karyawan }}" style="display:inline;">
                    <button type="button">Edit</button>
                </a>
                <form action="/hapus_karyawan/{{ $k->id_karyawan }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                    @csrf
                    <button type="submit" style="font-size: 12px; padding: 2px 6px;">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

</body>
</html>