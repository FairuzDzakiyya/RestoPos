<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengajuan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Pengajuan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pengaju</th>
                <th>Nama Barang</th>
                <th>Tanggal Pengajuan</th>
                <th>Qty</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengajuans as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->member->nama_member ?? '-' }}</td>
                    <td>{{ $p->nama_barang}}</td>
                    <td>{{ $p->tgl_pengajuan }}</td>
                    <td>{{ $p->qty }}</td>
                    <td>{{ $p->terpenuhi ? 'Terpenuhi' : 'Belum' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data pengajuan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>