@extends('templates.header.kasir')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center dark:bg-gray-700">
            <h2 class="text-2xl font-bold text-green-600">Transaksi Berhasil</h2>
            <p class="text-gray-300 mt-2">Tanggal Pesanan: {{ $pesanan->created_at->format('Y-m-d') }}</p>
            <p class="text-gray-300">Kembalian: Rp{{ number_format($kembalian, 0, ',', '.') }}</p>

            {{-- <a href="{{ route('printStruk', $pesanan->id) }}?auto_print=true&total={{ $pesanan->total }}&bayar={{ request('jumlah_uang') }}&kembalian={{ request('kembalian') }}" --}}
            <a href="{{ route('printStruk', $pesanan->id) }}?auto_print=true&total={{ $pesanan->total }}&kembalian={{ request('kembalian') }}"
                class="block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg mt-4">
                Print Struk
             </a>             
        </div>
    </div>
@endsection