<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $menu = DB::table('menus')->count();
        $penjualan = DB::table('pesanans')->sum('id');
        $pendapatan = DB::table('pesanans')->sum('total'); // karena 'pembayaran' nggak ada

        return view('admin.home.home', compact('menu', 'penjualan', 'pendapatan'));
    }

    public function chartData()
    {
        $data = DB::table('pesanans')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as transaksi, SUM(total) as pendapatan') // pakai total aja
            ->whereNotNull('total') // hindari NULL
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return response()->json($data);
    }

    public function kasir()
    {
        return view('kasir.home.home');
    }
    public function owner()
    {
        return view('owner.home.home');
    }
    public function laporan()
    {
        return view('owner.laporan.laporan');
    }


}
