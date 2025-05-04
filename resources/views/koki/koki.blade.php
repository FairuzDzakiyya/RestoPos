@extends('templates.header.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Pesanan Dapur</h1>
    <div id="notification" class="hidden p-4 mb-4 text-white bg-green-500 rounded">Pesanan baru masuk!</div>
    
    <table class="min-w-full bg-white border border-gray-300 rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2 border">No</th>
                <th class="p-2 border">Nama Menu</th>
                <th class="p-2 border">Jumlah</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody id="pesananTable">
            @foreach ($pesanans as $i => $pesanan)
            <tr class="text-center">
                <td class="p-2 border">{{ $i+1 }}</td>
                <td class="p-2 border">{{ $pesanan->menu->nama_menu }}</td>
                <td class="p-2 border">{{ $pesanan->jumlah }}</td>
                <td class="p-2 border">{{ ucfirst($pesanan->status) }}</td>
                <td class="p-2 border">
                    @if($pesanan->status == 'diproses')
                    <form action="{{ route('koki.selesai', $pesanan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">
                            Tandai Selesai
                        </button>
                    </form>
                    @else
                    <span class="text-green-600">Selesai</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
// Auto-refresh table tiap 5 detik (bisa diganti dengan Laravel Echo untuk real-time)
setInterval(() => {
    fetch('{{ route("koki.data") }}')
        .then(res => res.text())
        .then(html => {
            document.getElementById('pesananTable').innerHTML = html;
        });
}, 5000);
</script>
@endsection
