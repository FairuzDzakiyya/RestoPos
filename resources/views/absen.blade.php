@extends('templates.header.admin')

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
                                    <a href="#"
                                        class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Karyawan</a>
                                </div>
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
                                        aria-current="page">Absen</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Absensi Kerja Karyawan</h1>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex gap-3">
                        <button type="button" data-drawer-target="drawer-create-absen"
                            data-drawer-show="drawer-create-absen" aria-controls="drawer-create-absen"
                            data-drawer-placement="right"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            Tambah Data
                        </button>
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
                                <form action="{{ route('absen.import-excel') }}" method="POST"
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
                                <a href="{{ route('absen.export-excel') }}"
                                    class="block w-full text-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                    Export
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('absen.export-pdf') }}" target="_blank"
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
                    <div>
                        <form class="sm:pr-3" action="{{ route('absen') }}" method="GET">
                            <div class="relative">
                                <input type="text" name="search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    value="{{ request('search') }}" placeholder="Search">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table id="absensiTable" class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        No
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Nama Karyawan
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Tanggal Masuk
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Waktu Masuk
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Waktu Selesai Kerja
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse ($absensis as $index => $absen)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $index + 1 }}</td>
                                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $absen->user->name }}</div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $absen->tgl_absen }}</div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $absen->jam_masuk }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <select class="status-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" data-id="{{ $absen->id }}">
                                            <option value="masuk" {{ $absen->status == 'masuk' ? 'selected' : '' }}>Masuk</option>
                                            <option value="sakit" {{ $absen->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                            <option value="cuti" {{ $absen->status == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                        </select>
                                    </td>
                                    <td class="btn-selesai">
                                        @if ($absen->status == 'masuk' && !$absen->jam_keluar)
                                            <button id="btn-selesai" class="px-4 py-2 ml-6 bg-green-600 hover:bg-green-700 text-white rounded text-sm" data-id="{{ $absen->id }}">Selesai</button>
                                        @else
                                            <p class="px-10 text-base font-semibold text-gray-900 dark:text-white">
                                                {{ $absen->jam_keluar ? explode(' ', $absen->jam_keluar)[1] ?? $absen->jam_keluar : '00:00:00' }}
                                            </p>
                                        @endif
                                    </td>
                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <button onclick="updateAbsen('{{ $absen->id }}', {{ $absen->user_id }})" type="button"
                                            data-drawer-target="drawer-update-absen"
                                            data-drawer-show="drawer-update-absen"
                                            aria-controls="drawer-update-absen" data-drawer-placement="right"
                                            class="updateProductButton inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                </path>
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Edit
                                        </button>
                                            <button type="button" onclick="deleteAbsen({{ $absen->id }})"
                                                data-drawer-target="drawer-delete-absen" 
                                                data-drawer-show="drawer-delete-absen" 
                                                aria-controls="drawer-delete-absen" 
                                                data-drawer-placement="right" 
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Delete
                                            </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-white p-4">Data tidak tersedia</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700 rounded-b-xl">

            <div class="flex items-center mb-4 sm:mb-0">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Menampilkan
                    <span class="font-semibold text-gray-900 dark:text-white">
                        {{ $absensis->firstItem() }}
                    </span>
                    -
                    <span class="font-semibold text-gray-900 dark:text-white">
                        {{ $absensis->lastItem() }}
                    </span>
                    dari
                    <span class="font-semibold text-gray-900 dark:text-white">
                        {{ $absensis->total() }}
                    </span>
                </span>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ $absensis->previousPageUrl() ?? '#' }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg 
                   bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 
                   dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800
                   {{ $absensis->onFirstPage() ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                    <svg class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Sebelum
                </a>
                <a href="{{ $absensis->nextPageUrl() ?? '#' }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg 
                   bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 
                   dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800
                   {{ $absensis->hasMorePages() ? '' : 'opacity-50 cursor-not-allowed pointer-events-none' }}">
                    Selanjutnya
                    <svg class="w-5 h-5 ml-1 -mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>



        <!-- Add Product Drawer -->
        <div id="drawer-create-absen"
            class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800"
            tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
            <h5 id="drawer-label"
                class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Tambah Absen</h5>
            <button type="button" data-drawer-dismiss="drawer-create-absen"
                aria-controls="drawer-create-absen"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Kembali</span>
            </button>
            <form action="{{ route('postAbsen') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div class="mb-4">
                        <label class="block text-sm mb-2 font-medium text-white">Nama Karyawan</label>
                        <select name="user_id" id="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            <option value="" disabled selected>Pilih Karyawan</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm mb-2 font-medium text-white">Tanggal Masuk</label>
                        <input type="date" name="tgl_absen" id="tgl_absen" value="{{ $currentDate }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    </div>        
                    <div class="mb-4">
                        <label class="block text-sm mb-2 font-medium text-white">Waktu Masuk</label>
                        <input type="time" name="jam_masuk" id="jam_masuk" value="{{ $currentTime }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    </div>     
                    <div class="mb-4">
                        <label class="block text-sm mb-2 font-medium text-white">Status Masuk</label>
                        <select name="status" id="status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            required>
                            <option value="masuk">Masuk</option>
                            <option value="sakit">Sakit</option>
                            <option value="cuti">Cuti</option>
                        </select>
                    </div>
                        
                </div>
                <div class="bottom-0 left-0 flex justify-center w-full pb-4 mt-4 space-x-4 sm:absolute sm:px-4 sm:mt-0">
                    <button type="submit"
                        class="w-full justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="drawer-update-absen"
    class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-6 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800"
    tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
    <h5 id="drawer-label"
        class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
        Edit Absen</h5>
    <button type="button" data-drawer-dismiss="drawer-create-absen"
        aria-controls="drawer-create-absen"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Close menu</span>
    </button>
    <form id="updateAbsenForm" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="edit-id">
        <div class="mb-4">
            <label class="block text-sm mb-2 font-medium text-white">Nama Karyawan</label>
            <select name="user_id" id="updateAbsen" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                <option value="" disabled selected>Pilih Karyawan</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="w-full justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            Update
        </button>
    </form>
</div>

<div id="drawer-delete-absen"
            class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800"
            tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
            <h5 id="drawer-label"
                class="inline-flex items-center text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Delete
                item</h5>
            <button type="button" data-drawer-dismiss="drawer-delete-absen"
                aria-controls="drawer-delete-absen"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
            <svg class="w-10 h-10 mt-8 mb-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mb-6 text-lg text-gray-500 dark:text-gray-400">Are you sure you want to delete this product?</h3>
            @foreach ($absensis as $absen)
                <form id="deleteAbsenForm" method="POST" action="{{ route('hapusAbsen', $absen->id) }}">
            @endforeach
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2.5 text-center mr-2 dark:focus:ring-red-900">
                    Yes, I'm sure
                </button>
            </form>
            <button type="button"
                class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 border border-gray-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2.5 text-center dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                data-drawer-hide="drawer-delete-absen">
                No, cancel
            </button>
        </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<!-- JSZip -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<!-- PDFMake -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
    @if(session('success'))
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Berhasil!",
                    text: {!! json_encode(session('success')) !!},
                    icon: "success",
                    confirmButtonColor: "#4a69bd",
                    background: "#1e1e2f", // <- warna gelap
                    color: "#ffffff",

                    timerProgressBar: true,
                    showConfirmButton: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
            });
        @endif

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
    })

    // Inisialisasi DataTable
    $(document).ready(function () {
        $('#memberDataTable').DataTable({
            paging: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search...",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });

        // Fungsi search terpisah
        $('#table-search').on('keyup', function () {
            table.search(this.value).draw();
        });
    });
    $(document).ready(function () {
    // Setup CSRF untuk semua request AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Handle perubahan status (dropdown)
    $(document).on('change', '.status-select', function () {
    const id = $(this).data('id');
    const status = $(this).val();

    $.ajax({
        url: `/absen-kerja/status/${id}`,
        type: 'POST',
        data: {
            status: status,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            // Update tampilan jam keluar
            const row = $(`.status-select[data-id="${id}"]`).closest('tr');
            row.find('.btn-selesai').html(
                response.jam_keluar 
                    ? `<p class="text-white">${response.jam_keluar}</p>`
                    : '<button id="btn-selesai" class="px-4 py-2 ml-6 bg-green-600 hover:bg-green-700 text-white rounded text-sm" data-id="' + id + '">Selesai</button>'
            );
        },
        error: function (xhr, status, error) {
            console.error("Gagal update status:", error);
        }
    });
});

$(document).on('click', '#btn-selesai', function () {
    const id = $(this).data('id');
    const button = $(this);

    $.ajax({
        url: `/absen-kerja/selesai/${id}`,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            // Ganti tombol dengan waktu selesai
            button.closest('.btn-selesai').html(
                `<p class="text-white">${response.jam_keluar}</p>`
            );
        },
        error: function (xhr, status, error) {
            console.error("Gagal update jam_keluar:", error);
        }
    });
});
});

function updateAbsen(id, user_id) {
    document.getElementById("edit-id").value = id;
    document.getElementById("updateAbsen").value = user_id;
    document.getElementById("updateAbsenForm").action = `/absen-kerja/${id}`;
}

function deleteAbsen(id) {
        console.log("Deleting menu ID:", id);
        document.getElementById("deleteAbsenForm").action = `/absen-kerja/${id}`;
    }
</script>
@endsection