<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\laporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login');
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
});

Route::group(['middleware' => ['role:kasir,admin']], function () {
    Route::get('/kasir', [HomeController::class, 'kasir'])->name('kasir');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
    Route::get('/transaksi/tambah', [TransaksiController::class, 'addToCart'])->name('addToCart');
    Route::delete('/transaksi/hapus/{id}', [TransaksiController::class, 'removeFromCart'])->name('removeFromCart');

    Route::get('/pembayaran', [TransaksiController::class, 'show'])->name('pembayaran');
    Route::post('/pembayaran/proses', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::post('/transaksi/update-cart', [TransaksiController::class, 'updateCart'])->name('updateCart');
    // Route::get('/transaksi-berhasil', function () {
    //     return view('kasir.transaksi.berhasil');
    // })->name('transaksi.berhasil');
    Route::get('/transaksi/berhasil/{pesanan}', [TransaksiController::class, 'berhasil'])->name('transaksi.berhasil');
    Route::get('/transaksi/struk/{pesanan_id}', [TransaksiController::class, 'printStruk'])->name('printStruk');

    Route::get('/member', [MemberController::class, 'index'])->name('member');
    Route::post('/member/tambah', [MemberController::class, 'store'])->name('postMember');
    Route::put('/member/{id}', [MemberController::class, 'update'])->name('updateMember');
    Route::delete('/member/{id}', [MemberController::class, 'destroy'])->name('deleteMember');

    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan');
    Route::patch('/pengajuan/{id}/toggle-terpenuhi', [PengajuanController::class, 'toggleTerpenuhi'])->name('pengajuan.toggle-terpenuhi');
    Route::post('/pengajuan/tambah', [PengajuanController::class, 'store'])->name('postPengajuan');
    Route::put('/pengajuan/{id}', [PengajuanController::class, 'update'])->name('updatePengajuan');
    Route::delete('/pengajuan/{id}', [PengajuanController::class, 'destroy'])->name('hapusPengajuan');

    Route::get('/pengajuan/export-pdf', [PengajuanController::class, 'exportPdf'])->name('pengajuan.export-pdf');
    Route::get('/pengajuan/export-excel', [PengajuanController::class, 'exportExcel'])->name('pengajuan.export.excel');

});

Route::group(['middleware' => ['role:owner,admin']], function () {
    Route::get('/owner', [HomeController::class, 'owner'])->name('owner');

    Route::get('/laporan', [laporanController::class, 'index'])->name('laporan');
});