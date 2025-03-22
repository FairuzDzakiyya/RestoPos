@extends('templates.header.kasir')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-4">
        @if(request()->has('success') && request()->success)
            @include('kasir.transaksi.struk', [
                'total_harga' => request()->total_harga,
                'jumlah_uang' => request()->jumlah_uang,
                'kembalian' => request()->kembalian
            ])
        @else
            <h2 class="mb-4 mt-4 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Pembayaran</h2>

            <!-- TABEL PESANAN -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 p-6 dark:bg-gray-800">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Pesanan</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 dark:border-gray-700 mt-3">
                        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white">
                            <tr>
                                <th class="p-3">Menu</th>
                                <th class="p-3">Harga</th>
                                <th class="p-3">Qty</th>
                                <th class="p-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                            @php $totalHarga = 0; @endphp
                            @foreach($details as $id => $detail)
                                @php 
                                    $subtotal = $detail['harga'] * $detail['qty'];
                                    $totalHarga += $subtotal;
                                @endphp
                                <tr class="border-b dark:border-gray-700">
                                    <td class="p-3">{{ $detail['menu'] }}</td>
                                    <td class="p-3">Rp {{ number_format($detail['harga'], 0, ',', '.') }}</td>
                                    <td class="p-3 text-center">{{ $detail['qty'] }}</td>
                                    <td class="p-3">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-right text-xl font-bold dark:text-white">
                    Total: Rp {{ number_format($totalHarga, 0, ',', '.') }}
                </div>
            </div>

            <!-- FORM PEMBAYARAN -->
            <form action="{{ route('transaksi.store') }}" method="POST" class="mt-6">
                @csrf
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 p-6 dark:bg-gray-800">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Masukkan Pembayaran</h3>
                    <input type="hidden" name="total_harga" value="{{ $totalHarga }}">
                    <input type="hidden" name="items" value="{{ json_encode($details) }}">
                    <input type="number" name="jumlah_uang" min="{{ $totalHarga }}" required
                        class="w-full mt-2 p-2 border rounded-lg text-gray-900 dark:bg-gray-700 dark:text-white"
                        placeholder="Masukkan jumlah uang">
                </div>

                <!-- TOMBOL BAYAR -->
                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-2.5 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-700">
                        Beli Sekarang
                    </button>
                </div>
            </form>
        @endif
    </div>
@endsection