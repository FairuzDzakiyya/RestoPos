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
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 p-6 dark:bg-gray-800">
                <div class="flex flex-col md:flex-row justify-between gap-4">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Pesanan</h3>
                    @if ($member)
                    <p class="text-white">Member: {{ $member->nama_member ?? 'apa' }}</p>
                    @else
                    <p class="text-white">Transaksi Non-Member</p>
                @endif                
                </div>
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
            <form id="formPembayaran" action="{{ route('transaksi.store') }}" method="POST" class="mt-6">
                @csrf
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 p-6 dark:bg-gray-800">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Masukkan Pembayaran</h3>
                    <input type="hidden" name="total_harga" value="{{ $totalHarga }}">
                    <input type="hidden" name="items" value="{{ json_encode($details) }}">
                    @if(isset($member))
                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                    @endif
                    <input type="number" name="jumlah_uang" min="{{ $totalHarga }}" required
                        class="w-full mt-2 p-2 border rounded-lg text-gray-900 dark:bg-gray-700 dark:text-white"
                        placeholder="Masukkan jumlah uang">
                        <p id="errorUang" class="text-red-500 text-sm mt-2 hidden">Jumlah uang wajib diisi!</p>
                    </div>
                <!-- TOMBOL BAYAR -->
                <div class="mt-6 flex justify-end">
                    <button type="button" id="btnBayar"
                        class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-2.5 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-700">
                        Beli Sekarang
                    </button>
                </div>
            </form>
        </div><!-- MODAL KONFIRMASI -->
        <div id="modalBayar" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Konfirmasi Pembayaran</h2>
                <p class="text-gray-800 dark:text-white">Total: Rp <span id="modalTotalHarga"></span></p>
                <p class="text-gray-800 dark:text-white">Jumlah Uang: Rp <span id="modalJumlahUang"></span></p>
                <p class="text-gray-800 dark:text-white">Kembalian: Rp <span id="modalKembalian"></span></p>
        
                <div class="mt-4 flex justify-end gap-2">
                    <button onclick="document.getElementById('modalBayar').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-sm">Batal</button>
                    <button onclick="document.getElementById('formPembayaran').submit()"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded text-sm">Print Struk</button>
                </div>
            </div>
        </div>        
        @endif

    <script>
    const errorText = document.getElementById('errorUang');
    const btnBayar = document.getElementById('btnBayar');
    const modal = document.getElementById('modalBayar');

    btnBayar.addEventListener('click', () => {
        const inputJumlahUang = document.querySelector('input[name="jumlah_uang"]');
        const jumlahUang = parseInt(inputJumlahUang.value);
        const totalHarga = parseInt(document.querySelector('input[name="total_harga"]').value);

        // Reset error dulu
        errorText.classList.add('hidden');

        if (!inputJumlahUang.value) {
            errorText.textContent = "Jumlah uang wajib diisi!";
            errorText.classList.remove('hidden');
            inputJumlahUang.focus();
            return;
        }

        if (isNaN(jumlahUang)) {
            errorText.textContent = "Jumlah uang tidak valid!";
            errorText.classList.remove('hidden');
            inputJumlahUang.focus();
            return;
        }

        if (jumlahUang < totalHarga) {
            errorText.textContent = "Jumlah uang tidak mencukupi!";
            errorText.classList.remove('hidden');
            inputJumlahUang.focus();
            return;
        }

        const kembalian = jumlahUang - totalHarga;

        document.getElementById('modalTotalHarga').textContent = totalHarga.toLocaleString('id-ID');
        document.getElementById('modalJumlahUang').textContent = jumlahUang.toLocaleString('id-ID');
        document.getElementById('modalKembalian').textContent = kembalian.toLocaleString('id-ID');

        modal.classList.remove('hidden');
    });
    </script>    
@endsection