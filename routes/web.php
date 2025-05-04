<?php

use App\Http\Controllers\AbsenKerjaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\laporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('cek-login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin', [HomeController::class, 'index'])->name('admin');
    Route::get('/dashboard/chart', [HomeController::class, 'chartData']);

    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
    Route::post('/menu', [MenuController::class, 'store'])->name('postMenu');
    Route::post('/menu/update', [MenuController::class, 'update'])->name('updateMenu');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('deleteMenu');

    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('postKategori');
    Route::put('/Kategori/{id}', [KategoriController::class, 'update'])->name('updateKategori');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('deleteKategori');

    Route::get('/absen-kerja', [AbsenKerjaController::class, 'index'])->name('absen');
    Route::post('/absen-kerja', [AbsenKerjaController::class, 'store'])->name('postAbsen');
    Route::post('/absen-kerja/status/{id}', [AbsenKerjaController::class, 'updateStatus'])->name('updateStatusAbsen');
    Route::post('/absen-kerja/selesai/{id}', [AbsenKerjaController::class, 'selesaiKerja'])->name('selesaiKerja');
    Route::put('/absen-kerja/{id}', [AbsenKerjaController::class, 'update'])->name('updateAbsen');
    Route::delete('/absen-kerja/{id}', [AbsenKerjaController::class, 'destroy'])->name('hapusAbsen');
    Route::get('/absen-kerja/export-excel', [AbsenKerjaController::class, 'exportExcel'])->name('absen.export-excel');
    Route::post('/absen-kerja/import-excel', [AbsenKerjaController::class, 'importExcel'])->name('absen.import-excel');
    Route::get('/absen-kerja/export-pdf', [AbsenKerjaController::class, 'exportPdf'])->name('absen.export-pdf');

});

Route::group(['middleware' => ['role:kasir']], function () {
    Route::get('/kasir', [HomeController::class, 'kasir'])->name('kasir');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
    Route::get('/transaksi/tambah', [TransaksiController::class, 'addToCart'])->name('addToCart');
    Route::delete('/transaksi/hapus/{id}', [TransaksiController::class, 'removeFromCart'])->name('removeFromCart');

    Route::get('/pembayaran', [TransaksiController::class, 'show'])->name('pembayaran');
    Route::post('/pembayaran/proses', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::post('/transaksi/update-cart', [TransaksiController::class, 'updateCart'])->name('updateCart');
    Route::post('/transaksi/cek-member', [TransaksiController::class, 'cekMember'])->name('cek.member');

    Route::get('/transaksi/berhasil/{pesanan}', [TransaksiController::class, 'berhasil'])->name('transaksi.berhasil');
    Route::get('/transaksi/struk/{pesanan_id}', [TransaksiController::class, 'printStruk'])->name('printStruk');


    Route::get('/member', [MemberController::class, 'index'])->name('member');
    Route::post('/member/tambah', [MemberController::class, 'store'])->name('postMember');
    Route::put('/member/{id}', [MemberController::class, 'update'])->name('updateMember');
    Route::delete('/member/{id}', [MemberController::class, 'destroy'])->name('deleteMember');

    Route::post('/member/import-excel', [MemberController::class, 'importExcel'])->name('member.import-excel');
    Route::get('/member/export-excel', [MemberController::class, 'exportExcel'])->name('member.export-excel');
    Route::get('/member/export-pdf', [MemberController::class, 'exportPdf'])->name('member.export-pdf');

    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan');
    Route::post('/pengajuan/{id}/toggle-terpenuhi', [PengajuanController::class, 'toggleTerpenuhi'])->name('pengajuan.toggle-terpenuhi');
    Route::post('/pengajuan/tambah', [PengajuanController::class, 'store'])->name('postPengajuan');
    Route::put('/pengajuan/{id}', [PengajuanController::class, 'update'])->name('updatePengajuan');
    Route::delete('/pengajuan/{id}', [PengajuanController::class, 'destroy'])->name('deletePengajuan');

    Route::get('/pengajuan/export-pdf', [PengajuanController::class, 'exportPdf'])->name('pengajuan.export-pdf');
    Route::get('/pengajuan/export-excel', [PengajuanController::class, 'exportExcel'])->name('pengajuan.export.excel');

});

Route::group(['middleware' => ['role:owner']], function () {
    Route::get('/owner', [HomeController::class, 'owner'])->name('owner');

    Route::get('/laporan', [laporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/export-excel', [laporanController::class, 'exportExcel'])->name('laporan.export-excel');
    Route::get('/laporan', [laporanController::class, 'index'])->name('laporan');

    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan');
    Route::post('/karyawan', [KaryawanController::class, 'store'])->name('postKaryawan');
    Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('updateKaryawan');
    Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('hapusKaryawan');
});