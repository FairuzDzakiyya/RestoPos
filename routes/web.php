<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('cek-login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', function () {
        return view('home.home');
    })->name('home');

    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
    // Route::get('/menu/create', [MenuController::class, 'create'])->name('createMenu');
    Route::post('/menu', [MenuController::class, 'store'])->name('postMenu');
    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('updateMenu');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('deleteMenu');
    
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('postKategori');
    Route::put('/Kategori/{id}', [KategoriController::class, 'update'])->name('updateKategori');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('deleteKategori');
});