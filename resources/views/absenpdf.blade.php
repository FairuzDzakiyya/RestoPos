<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Absen</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Absen</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Tanggal Masuk</th>
                <th>Waktu Masuk</th>
                <th>Status</th>
                <th>Waktu Selesai Kerja</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($absensi as $index => $absen)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $absen->user->name ?? '-' }}</td>
                    <td>{{ $absen->tgl_absen }}</td>
                    <td>{{ $absen->jam_masuk }}</td>
                    <td>{{ $absen->jam_keluar }}</td>
                    <td>{{ $absen->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data absen</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>