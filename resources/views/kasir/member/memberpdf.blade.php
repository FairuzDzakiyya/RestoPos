<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Member</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Member</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Member</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members as $index => $member)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $member->nama_member ?? '-' }}</td>
                    <td>{{ $member->alamat}}</td>
                    <td>{{ $member->telp }}</td>
                    <td>{{ $member->email }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data member</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>