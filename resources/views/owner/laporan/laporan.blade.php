@extends('templates.header.owner')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-4">
        <div
            class="p-4 bg-white block sm:flex items-center justify-between border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700 rounded-t-xl">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Laporan</h1>
                </div>       
                <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                    <div class="flex items-center mb-4 sm:mb-0">
                        <form class="sm:pr-3" action="#" method="GET">
                            <label for="products-search" class="sr-only">Search</label>
                            <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                                <input type="text" name="email" id="products-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search for products">
                            </div>
                        </form>
                    </div>
                    <div class="flex gap-2">
                        <div>
                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                <a href="{{ route('laporan', ['jenis' => 'transaksi']) }}"
                                    class="px-4 py-2 text-sm font-medium border rounded-l-lg
                                        {{ request('jenis') === 'transaksi' || !request()->has('jenis') ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                                    Laporan Transaksi
                                </a>
                                <a href="{{ route('laporan', ['jenis' => 'penjualan']) }}"
                                    class="px-4 py-2 text-sm font-medium border-t border-b border-r rounded-r-lg
                                        {{ request('jenis') === 'penjualan' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                                    Laporan Penjualan Barang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="table-auto w-full text-sm">
                            @if (request('jenis') === 'penjualan')
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">No</th>
                                    <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Menu</th>
                                    <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Stok</th>
                                    <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Stok Terjual</th>
                                    <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Keuntungan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($details as $index => $item)
                                    @php
                                        $harga_modal = $item->menu->harga_modal;
                                        $total_modal = $item->total_qty * $harga_modal;
                                        $keuntungan = $item->total_pendapatan - $total_modal;
                                    @endphp
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="p-4 text-sm text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                                        <td class="p-4 text-sm text-gray-900 dark:text-white">{{ $item->menu->menu }}</td>
                                        <td class="p-4 text-sm text-gray-900 dark:text-white">{{ $item->menu->stok }}</td>
                                        <td class="p-4 text-sm text-gray-900 dark:text-white">{{ $item->total_qty }}</td>
                                        <td class="p-4 text-sm text-gray-900 dark:text-white">Rp{{ number_format($keuntungan, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                            
                        @else
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    @if ($errors->any())
                                        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-900 dark:text-red-400"
                                            role="alert">
                                            <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                            </svg>
                                            <span class="sr-only">Danger</span>
                                            <div>
                                                <ul class="mt-1.5 list-disc list-inside">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Karyawan
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Tanggal Pesanan
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Total
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Detail
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($pesanans as $pesanan)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            <div class="text-base font-semibold text-gray-900 dark:text-white">
                                                {{ $pesanan->id }}
                                            </div>
                                        </td>
                                        <td
                                            class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">
                                            {{ $pesanan->karyawan->name ?? '-' }}
                                        </td>
                                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $pesanan->tgl_pesan }}
                                        </td>
                                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Rp {{ number_format($pesanan->total, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <button onclick="openModal('pesananModal-{{ $pesanan->id }}')"
                                                class="text-blue-600 hover:underline">
                                                Detail Pesanan
                                            </button>
                                        </td>
                                        <td class="p-4 whitespace-nowrap">
                                            <span
                                                class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500">{{ $pesanan->status }}</span>
                                        </td>
                                    </tr>

                                    <div id="pesananModal-{{ $pesanan->id }}"
                                        class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900 bg-opacity-50 flex items-center justify-center">
                                        <div class="bg-gray-700 rounded-lg shadow-md p-6 w-full max-w-lg">
                                            <div class="flex justify-between items-center border-b pb-3">
                                                <h5 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Pesanan
                                                </h5>
                                                <button onclick="closeModal('pesananModal-{{ $pesanan->id }}')"
                                                    class="text-gray-500 hover:text-gray-700">
                                                    ✕
                                                </button>
                                            </div>
                                            <div class="mt-4">
                                                <p class="text-lg font-bold text-black dark:text-white">ID Pesanan:
                                                    {{ $pesanan->id }}
                                                </p>
                                                <p class="text-lg font-bold text-black dark:text-white">Karyawan:
                                                    {{ $pesanan->karyawan->name ?? '-' }}
                                                </p>
                                                <p class="text-lg font-bold text-black dark:text-white">Tanggal Pesanan:
                                                    {{ $pesanan->tgl_pesan }}
                                                </p>
                                                <hr class="my-3">
                                                <h5 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Menu</h5>
                                                @if (!empty($pesanan->details) && count($pesanan->details) > 0)
                                                    <ul class="list-disc pl-5 text-gray-900 dark:text-white">
                                                        @foreach ($pesanan->details as $detail)
                                                            <li>{{ $detail->menu->menu ?? 'Tidak ada' }} -
                                                                Qty: {{ $detail->qty }} -
                                                                Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="text-gray-500">Tidak ada detail pesanan.</p>
                                                @endif
                                            </div>
                                            <div class="mt-4 text-right">
                                                <button onclick="closeModal('pesananModal-{{ $pesanan->id }}')"
                                                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                                                    Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        @endif                        
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700 rounded-b-xl">
            <div class="flex items-center mb-4 sm:mb-0">
                <a href="#"
                    class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
                <a href="#"
                    class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Showing <span
                        class="font-semibold text-gray-900 dark:text-white">1-20</span> of <span
                        class="font-semibold text-gray-900 dark:text-white">2290</span></span>
            </div>
            <div class="flex items-center space-x-3">
                <a href="#"
                    class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    <svg class="w-5 h-5 mr-1 -ml-1" fill=" currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Previous
                </a>
                <a href="#"
                    class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    Next
                    <svg class="w-5 h-5 ml-1 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>
@endsection