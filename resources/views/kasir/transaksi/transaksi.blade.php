@extends('templates.header.kasir')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-4">
        <h2 class="mb-4 mt-4 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Menu</h2>
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($menus as $menu)
                <div
                    class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <img class="p-6 rounded-lg object-cover w-full h-48" src="{{ asset($menu->gambar) }}"
                        alt="{{ $menu->menu }}" />
                    <div class="px-5 pb-5">
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $menu->kategori->nama_kategori ?? '-' }}</p>
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $menu->menu }}</h5>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Stok: {{ $menu->stok }}</p>
                        <div class="flex keranjangs-center justify-between mt-4">
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">Rp
                                {{ number_format($menu->harga, 0, ',', '.') }}</span>
                            <button onclick="addToCart({{ $menu->id }})"
                                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
                                Tambah
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 p-6 dark:bg-gray-800">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Keranjang Pesanan</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border border-gray-200 dark:border-gray-700 mt-3">
                    <thead class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white">
                        <tr>
                            <th class="p-3">Menu</th>
                            <th class="p-3">Harga</th>
                            <th class="p-3">Qty</th>
                            <th class="p-3">Subtotal</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $item)
                            @php $subtotal = $item['harga'] * $item['qty']; @endphp
                            <tr class="border-b dark:border-gray-700">
                                <td class="p-3">{{ $item['menu'] }}</td>
                                <td class="p-3">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                <td class="p-3 text-center">
                                    <form id="update-form-{{ $id }}" action="{{ route('updateCart') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <input type="number" name="qty" id="qty-{{ $id }}" value="{{ $item['qty'] }}" min="1"
                                            class="w-16 text-center border rounded-md dark:bg-gray-800 dark:text-white"
                                            onchange="updateQty({{ $id }})">
                                    </form>
                                </td>


                                <td class="p-3">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                <td class="p-3 text-center">
                                    <form action="{{ route('removeFromCart', $id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-white text-sm rounded-lg focus:ring-4 focus:outline-none focus:ring-red-600 bg-red-500 hover:bg-red-700 px-5 py-2.5">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @php $total += $subtotal; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right text-xl font-bold dark:text-white">
                Total: Rp
                {{ number_format(array_sum(array_map(fn($item) => $item['harga'] * $item['qty'], $cart)), 0, ',', '.') }}
            </div>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('pembayaran') }}"
                    class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-2.5">
                    Lanjut ke Pembayaran
                </a>
            </div>
        </div>
    </div>

    <script>
        function addToCart(menuId) {
            window.location.href = "{{ route('addToCart') }}?id=" + menuId;
        }
        function updateQty(id) {
            let input = document.getElementById("qty-" + id);
            let form = document.getElementById("update-form-" + id);

            if (parseInt(input.value) < 1) input.value = 1; // Biar tidak bisa di bawah 1

            form.submit(); // Kirim form otomatis ke Laravel
        }

    </script>
@endsection