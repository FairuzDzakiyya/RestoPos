@extends('templates.header.owner')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-4">
        <div
            class="p-4 bg-white block sm:flex items-center justify-between border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700 rounded-t-xl">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <nav class="flex mb-5" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                            <li class="inline-flex items-center">
                                <a href="#"
                                    class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                    <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                        </path>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500"
                                        aria-current="page">Laporan</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Laporan</h1>
                </div>
                <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center mb-4 sm:mb-0 gap-2 sm:gap-4">
                        <form action="{{ route('laporan') }}" method="GET"
                            class="flex flex-col sm:flex-row gap-2 sm:items-center">
                            <input type="hidden" name="jenis" value="{{ request('jenis') }}">

                            {{-- Search --}}
                            <input type="text" name="search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Cari Karyawan/Menu" value="{{ request('search') }}">

                            <div class="relative">
                                <!-- Trigger Button -->
                                <button type="button" id="filterButton"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-4 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                    Filter
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Dropdown Panel -->
                                <div id="filterDropdown"
                                    class="absolute z-10 hidden w-80 p-4 mt-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                    <form method="GET" action="{{ route('laporan') }}">
                                        <input type="hidden" name="jenis" value="{{ request('jenis') }}">

                                        <div class="mb-4">
                                            <label
                                                class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Start
                                                date</label>
                                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                                class="w-full px-3 py-2 text-sm border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        </div>

                                        <div class="mb-4">
                                            <label
                                                class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">End
                                                date</label>
                                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                                class="w-full px-3 py-2 text-sm border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        </div>

                                        <div class="flex justify-between gap-2">
                                            <button type="submit"
                                                class="w-full px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                                Terapkan
                                            </button>

                                            <a href="{{ route('laporan', array_filter([
        'jenis' => request('jenis'),
        'search' => request('search') // biar search tetap kepake pas clear
    ])) }}"
                                                class="w-full px-3 py-2 text-sm text-center font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                                Clear
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <div class="relative">
                                    <button id="excelDropdownButton" type="button"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-4 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                        Excel
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown content -->
                                    <div id="excelDropdown"
                                        class="absolute z-10 hidden w-80 p-4 mt-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                        <!-- Import Form -->
                                        <form action="#" method="POST"
                                            enctype="multipart/form-data" class="mb-3">
                                            @csrf
                                            <input type="file" name="file" required
                                                class="w-full border px-3 py-2 rounded mb-3 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <button type="submit"
                                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                                Import
                                            </button>
                                        </form>

                                        <!-- Export Button -->
                                        <a href="{{ route('laporan.export-excel') }}"
                                            class="block w-full text-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                            Export
                                        </a>
                                    </div>
                                </div>
                                <a href="#" target="_blank"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                    <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Export PDF
                                </a>
                            </div>
                        </form>
                    </div>

                    {{-- Tombol Pilihan Jenis Laporan --}}
                    <div class="flex gap-2 mt-4 sm:mt-0 sm:pl-4">
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <a href="{{ route('laporan', ['jenis' => 'transaksi']) }}"
                                class="px-4 py-2 text-sm font-medium border rounded-l-lg
                                                                                    {{ request('jenis') === 'transaksi' || !request()->has('jenis') ? 'bg-blue-600 text-white border-blue-600' : 'bg-gray-600 text-white border-gray-600 hover:bg-gray-700' }}">
                                Laporan Transaksi
                            </a>
                            <a href="{{ route('laporan', ['jenis' => 'penjualan']) }}"
                                class="px-4 py-2 text-sm font-medium border-t border-b border-r rounded-r-lg
                                                                                    {{ request('jenis') === 'penjualan' ? 'bg-blue-600 text-white border-blue-600' : 'bg-gray-600 text-white border-gray-600 hover:bg-gray-700' }}">
                                Laporan Penjualan Barang
                            </a>
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
                                                        <th
                                                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                            No</th>
                                                        <th
                                                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                            Menu</th>
                                                        <th
                                                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                            Stok</th>
                                                        <th
                                                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                            Stok Terjual</th>
                                                        <th
                                                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                            Keuntungan</th>
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
                                                                                <td class="p-4 text-sm text-gray-900 dark:text-white">
                                                                                    Rp{{ number_format($keuntungan, 0, ',', '.') }}</td>
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
                                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                                <!-- Modal content -->
                                                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                                    <!-- Modal header -->
                                                    <div
                                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                            Detail Pesanan
                                                        </h3>
                                                        <button type="button" onclick="closeModal('pesananModal-{{ $pesanan->id }}')"
                                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                            data-modal-hide="default-modal">
                                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                            </svg>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="p-4 md:p-5 space-y-4">
                                                        <p class="text-lg text-black dark:text-white">ID Pesanan:
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
                                                    <!-- Modal footer -->
                                                    <div
                                                        class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                        <button onclick="closeModal('pesananModal-{{ $pesanan->id }}')" type="button"
                                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">OK</button>
                                                    </div>
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
        @if ($pesanans)
            <div
                class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700 rounded-b-xl">
                <div class="flex items-center mb-4 sm:mb-0">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Menampilkan
                        <span class="font-semibold text-gray-900 dark:text-white">
                            {{ $pesanans->firstItem() }}
                        </span>
                        -
                        <span class="font-semibold text-gray-900 dark:text-white">
                            {{ $pesanans->lastItem() }}
                        </span>
                        dari
                        <span class="font-semibold text-gray-900 dark:text-white">
                            {{ $pesanans->total() }}
                        </span>
                    </span>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ $pesanans->previousPageUrl() ?? '#' }}"
                        class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg 
                                                                                                                           bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 
                                                                                                                           dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800
                                                                                                                           {{ $pesanans->onFirstPage() ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                        <svg class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Sebelum
                    </a>
                    <a href="{{ $pesanans->nextPageUrl() ?? '#' }}"
                        class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg 
                                                                                                                           bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 
                                                                                                                           dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800
                                                                                                                           {{ $pesanans->hasMorePages() ? '' : 'opacity-50 cursor-not-allowed pointer-events-none' }}">
                        Selanjutnya
                        <svg class="w-5 h-5 ml-1 -mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        @endif

    </div>
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
        document.addEventListener('DOMContentLoaded', function () {
            const button = document.getElementById('filterButton');
            const dropdown = document.getElementById('filterDropdown');

            button.addEventListener('click', function () {
                dropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function (e) {
                if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Dropdown Excel
            const excelBtn = document.getElementById('excelDropdownButton');
            const excelDropdown = document.getElementById('excelDropdown');
            let dropdownVisible = false;

            if (excelBtn && excelDropdown) {
                // Toggle dropdown
                excelBtn.addEventListener('click', function () {
                    dropdownVisible = !dropdownVisible;
                    excelDropdown.classList.toggle('hidden', !dropdownVisible);
                });

                // Tutup dropdown saat klik di luar
                document.addEventListener('click', function (e) {
                    const isClickInside = excelBtn.contains(e.target) || excelDropdown.contains(e.target);
                    if (!isClickInside && dropdownVisible) {
                        dropdownVisible = false;
                        excelDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endsection